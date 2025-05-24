<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Payment;
use App\Models\GenerateReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


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




    public function showPayment()
    {
        //
        $totalCollected = \App\Models\Payment::where('payment_status', 'Complete')->sum('payment_amount');

        // Payment status breakdown
        $paidCount = \App\Models\Payment::where('payment_status', 'Complete')->count();
        $unpaidCount = \App\Models\Payment::where('payment_status', 'Pending')->count();
        $overdueCount = \App\Models\Payment::where('payment_status', 'Overdue')->count();

        // Monthly, weekly, daily trend
        $monthlyTrend = \App\Models\Payment::selectRaw("DATE_FORMAT(paymentByParents_date, '%Y-%m') as period, COUNT(*) as total")
            ->groupBy('period')->orderBy('period')->get();
        $weeklyTrend = \App\Models\Payment::selectRaw("YEAR(paymentByParents_date) as year, WEEK(paymentByParents_date, 1) as week, COUNT(*) as total")
            ->groupBy('year', 'week')->orderBy('year')->orderBy('week')->get();
        $dailyTrend = \App\Models\Payment::selectRaw("DATE(paymentByParents_date) as period, COUNT(*) as total")
            ->groupBy('period')->orderBy('period')->get();

        // All payments for table
        $payments = \App\Models\Payment::with(['child', 'parentRecord'])->latest()->get();

        return view('generateReports.paymentReport', compact(
            'totalCollected', 'paidCount', 'unpaidCount', 'overdueCount',
            'monthlyTrend', 'weeklyTrend', 'dailyTrend', 'payments'
        ));
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

     public function exportPdf(Request $request)
    {
        $selectedDate = $request->input('selected_date', now()->format('Y-m-d'));
        $attendances = Attendance::with('child')
            ->where('attendance_date', $selectedDate)
            ->get();

        $pdf = Pdf::loadView('generateReports.attendancePDf', compact('attendances', 'selectedDate'));
        return $pdf->download('attendance_report_' . $selectedDate . '.pdf');
    }
}
