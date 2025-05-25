<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Payment;
use App\Models\GenerateReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class GenerateReportController extends Controller
{

    public function index(Request $request)
    {
        $selectedDate = $request->get('selected_date', now()->format('Y-m-d'));

        $allAttendances = Attendance::with('child')->get();
        $attendances = Attendance::with('child')->whereDate('attendance_date', $selectedDate)->get();

        $totalChildren = Child::whereHas('enrollment', fn($q) => $q->where('status', 'approved'))->count();
        $presentCount = $attendances->where('attendance_status', 'attend')->count();
        $absentCount = $attendances->where('attendance_status', 'absent')->count();
        $attendanceRate = $totalChildren > 0 ? round(($presentCount / $totalChildren) * 100) : 0;

        // Grouped Overtime Data
        $overtimeDaily = Attendance::selectRaw('attendance_date, ABS(SUM(attendance_overtime)) as total')
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get()
            ->map(fn($a) => [
                'label' => $a->attendance_date,
                'total' => (int)$a->total,
            ]);

        $overtimeWeekly = Attendance::selectRaw("YEAR(attendance_date) as year, WEEK(attendance_date, 1) as week, ABS(SUM(attendance_overtime)) as total")
            ->groupBy('year', 'week')
            ->orderBy('year')->orderBy('week')
            ->get()
            ->map(fn($a) => [
                'label' => "{$a->year}-W{$a->week}",
                'total' => (int)$a->total,
            ]);

        $overtimeMonthly = Attendance::selectRaw("DATE_FORMAT(attendance_date, '%Y-%m') as month, ABS(SUM(attendance_overtime)) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($a) => [
                'label' => $a->month,
                'total' => (int)$a->total,
            ]);

        // Grouped Attendance Data (for Pie Chart)
        $attendanceDaily = Attendance::selectRaw('attendance_date, attendance_status, COUNT(*) as total')
            ->groupBy('attendance_date', 'attendance_status')
            ->orderBy('attendance_date')
            ->get();

        $attendanceWeekly = Attendance::selectRaw("YEAR(attendance_date) as year, WEEK(attendance_date, 1) as week, attendance_status, COUNT(*) as total")
            ->groupBy('year', 'week', 'attendance_status')
            ->orderBy('year')->orderBy('week')
            ->get();

        $attendanceMonthly = Attendance::selectRaw("DATE_FORMAT(attendance_date, '%Y-%m') as month, attendance_status, COUNT(*) as total")
            ->groupBy('month', 'attendance_status')
            ->orderBy('month')
            ->get();

        // Child Attendance Trends by Daily, Weekly, Monthly
        $childAttendanceRaw = Attendance::selectRaw("
            children_id,
            attendance_status,
            attendance_date,
            DATE_FORMAT(attendance_date, '%Y-%m-%d') as daily,
            DATE_FORMAT(attendance_date, '%Y-%u') as weekly,
            DATE_FORMAT(attendance_date, '%Y-%m') as monthly
        ")
        ->where('attendance_status', 'attend')
        ->with('child')
        ->get();

        $groupedTrends = ['daily' => [], 'weekly' => [], 'monthly' => []];

        foreach (['daily', 'weekly', 'monthly'] as $period) {
            $temp = [];
            foreach ($childAttendanceRaw->groupBy($period) as $label => $entries) {
                $childrenGroup = [];
                foreach ($entries->groupBy('child.name') as $childName => $records) {
                    $childrenGroup[$childName] = $records->count();
                }
                $temp[] = [
                    'label' => $label,
                    'children' => $childrenGroup
                ];
            }
            $groupedTrends[$period] = $temp;
        }

        // Get all children names
        $children = \App\Models\Child::pluck('child_name')->toArray();

        // Prepare periods (daily, weekly, monthly)
        $periods = [
            'daily' => Attendance::selectRaw("DATE_FORMAT(attendance_date, '%Y-%m-%d') as period")->distinct()->pluck('period')->toArray(),
            'weekly' => Attendance::selectRaw("DATE_FORMAT(attendance_date, '%Y-%u') as period")->distinct()->pluck('period')->toArray(),
            'monthly' => Attendance::selectRaw("DATE_FORMAT(attendance_date, '%Y-%m') as period")->distinct()->pluck('period')->toArray(),
        ];


        return view('generateReports.attendanceReport', compact(
            'attendances', 'selectedDate',
            'totalChildren', 'presentCount', 'absentCount',
            'attendanceRate',
            'overtimeDaily', 'overtimeWeekly', 'overtimeMonthly',
            'attendanceDaily', 'attendanceWeekly', 'attendanceMonthly',
            'groupedTrends'
        ))->with('childAttendanceTrends', $groupedTrends);
    }




    public function showPayment(Request $request)
{
    // Get the selected date from the request (default to today)
    $selectedDate = $request->get('selected_date', now()->format('Y-m-d'));

    // Base query filtered by selected date
    // Only include payments where paymentByParents_date matches the selected date
    $baseQuery = \App\Models\Payment::whereDate('paymentByParents_date', $selectedDate);

    // Total collected on selected date, only completed payments
    $totalCollected = (clone $baseQuery)
        ->where('payment_status', 'Complete')
        ->sum('payment_amount');

    // Payment status breakdown on selected date
    $paidCount = (clone $baseQuery)->where('payment_status', 'Complete')->count();
    $unpaidCount = (clone $baseQuery)->where('payment_status', 'Pending')->count();
    $overdueCount = (clone $baseQuery)->where('payment_status', 'Overdue')->count();

    // Monthly trend for payments that happened in the month of selectedDate
    $monthStart = now()->parse($selectedDate)->startOfMonth()->format('Y-m-d');
    $monthEnd = now()->parse($selectedDate)->endOfMonth()->format('Y-m-d');
    $monthlyTrend = \App\Models\Payment::selectRaw("DATE_FORMAT(paymentByParents_date, '%Y-%m') as period, COUNT(*) as total")
        ->whereBetween('paymentByParents_date', [$monthStart, $monthEnd])
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    // Weekly trend for payments that happened in the week of selectedDate
    $weekStart = now()->parse($selectedDate)->startOfWeek()->format('Y-m-d');
    $weekEnd = now()->parse($selectedDate)->endOfWeek()->format('Y-m-d');
    $weeklyTrend = \App\Models\Payment::selectRaw("YEAR(paymentByParents_date) as year, WEEK(paymentByParents_date, 1) as week, COUNT(*) as total")
        ->whereBetween('paymentByParents_date', [$weekStart, $weekEnd])
        ->groupBy('year', 'week')
        ->orderBy('year')
        ->orderBy('week')
        ->get();

    // Daily trend for payments for the selected date only
    $dailyTrend = \App\Models\Payment::selectRaw("DATE(paymentByParents_date) as period, COUNT(*) as total")
        ->whereDate('paymentByParents_date', $selectedDate)
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    // Fetch all payments on the selected date for the table, with relations loaded
    $payments = \App\Models\Payment::with(['child', 'parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian'])
        ->whereDate('paymentByParents_date', $selectedDate)
        ->latest()
        ->get();

    // Pass all data to the view
    return view('generateReports.paymentReport', compact(
        'selectedDate',
        'totalCollected', 'paidCount', 'unpaidCount', 'overdueCount',
        'monthlyTrend', 'weeklyTrend', 'dailyTrend', 'payments'
    ));
}



    public function exportPDF(Request $request)
    {
        $chartImage = $request->input('chartImage');
        $selectedDate = $request->input('selected_date');

        $childParents = \App\Models\Payment::with(['child', 'parentRecord'])->latest()->get();


        // Query data as needed
        $payments = Payment::with('child', 'parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian')
            ->whereDate('created_at', $selectedDate)
            ->get();

        $paidCount = \App\Models\Payment::where('payment_status', 'Complete')->count();
        $unpaidCount = \App\Models\Payment::where('payment_status', 'Pending')->count();
        $overdueCount = \App\Models\Payment::where('payment_status', 'Overdue')->count();

        $totalCollected = \App\Models\Payment::where('payment_status', 'Complete')->sum('payment_amount');
        
        $pdf = Pdf::loadView('generateReports.payment-pdf', compact('childParents', 
            'chartImage', 'selectedDate', 'payments', 'totalCollected', 'paidCount', 'unpaidCount', 'overdueCount'
        ));

        return $pdf->download("payment_report_$selectedDate.pdf");
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GenerateReport $generateReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenerateReport $generateReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GenerateReport $generateReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenerateReport $generateReport)
    {
        //
    }

    //  public function exportPdf(Request $request)
    // {
    //     $selectedDate = $request->input('selected_date', now()->format('Y-m-d'));
    //     $attendances = Attendance::with('child')
    //         ->where('attendance_date', $selectedDate)
    //         ->get();

    //     $pdf = Pdf::loadView('generateReports.attendancePDf', compact('attendances', 'selectedDate'));
    //     return $pdf->download('attendance_report_' . $selectedDate . '.pdf');
    // }
}
