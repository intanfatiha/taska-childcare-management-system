<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Payment;
use App\Models\ParentRecord;
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
            DATE_FORMAT(attendance_date, '%d-%m-%Y') as daily,
            DATE_FORMAT(attendance_date, '%Y-%u') as weekly,
            DATE_FORMAT(attendance_date, '%m-%Y') as monthly
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

public function exportPdfAttendance(Request $request)
{
    $selectedDate = $request->input('selected_date') ?? now()->toDateString();
    
    // Get chart images from request (if using chart capture method)
    $pieChartImage = $request->input('pieChartImage');
    $barChartImage = $request->input('barChartImage');

    $attendances = Attendance::with('child')
        ->whereDate('attendance_date', $selectedDate)
        ->get();
    
    $totalChildren = Child::whereHas('enrollment', fn($q) => $q->where('status', 'approved'))->count();
    $presentCount = $attendances->where('attendance_status', 'attend')->count();
    $absentCount = $attendances->where('attendance_status', 'absent')->count();
    $attendanceRate = $totalChildren > 0 ? round(($presentCount / $totalChildren) * 100, 2) : 0;

    // If no chart images captured, generate them using QuickChart
    if (!$pieChartImage) {
        $pieChartImage = $this->generateChartBase64($presentCount, $absentCount);
    } else {
        // Remove the data:image/png;base64, prefix if it exists
        $pieChartImage = str_replace('data:image/png;base64,', '', $pieChartImage);
    }

    if (!$barChartImage) {
        $barChartImage = $this->generateOvertimeBarChart($selectedDate);
    } else {
        // Remove the data:image/png;base64, prefix if it exists
        $barChartImage = str_replace('data:image/png;base64,', '', $barChartImage);
    }

    $pdf = Pdf::loadView('generateReports.attendancePDF', [
        'selectedDate' => $selectedDate,
        'attendances' => $attendances,
        'totalChildren' => $totalChildren,
        'presentCount' => $presentCount,
        'absentCount' => $absentCount,
        'attendanceRate' => $attendanceRate,
        'pieChartImage' => $pieChartImage,
        'barChartImage' => $barChartImage
    ]);

    return $pdf->download('attendance_report_' . $selectedDate . '.pdf');
}

private function generateOvertimeBarChart($selectedDate)
{
    // Get overtime data for the past 7 days including selected date
    $startDate = \Carbon\Carbon::parse($selectedDate)->subDays(6)->format('Y-m-d');
    $endDate = $selectedDate;
    
    $overtimeData = Attendance::selectRaw('attendance_date, ABS(SUM(attendance_overtime)) as total_overtime')
        ->whereBetween('attendance_date', [$startDate, $endDate])
        ->groupBy('attendance_date')
        ->orderBy('attendance_date')
        ->get();

    // Prepare data for chart
    $labels = [];
    $data = [];
    
    // Fill in missing dates with 0 values
    for ($date = \Carbon\Carbon::parse($startDate); $date->lte(\Carbon\Carbon::parse($endDate)); $date->addDay()) {
        $dateStr = $date->format('Y-m-d');
        $labels[] = $date->format('M j'); // Short format for labels
        
        $found = $overtimeData->firstWhere('attendance_date', $dateStr);
        $data[] = $found ? (int)$found->total_overtime : 0;
    }

    $chartUrl = 'https://quickchart.io/chart';
    $chartData = [
        'type' => 'bar',
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Overtime (minutes)',
                'data' => $data,
                'backgroundColor' => '#3498db',
                'borderColor' => '#2980b9',
                'borderWidth' => 1
            ]]
        ],
        'options' => [
            'responsive' => true,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => 'Overtime Summary (Past 7 Days)'
                ]
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Minutes'
                    ]
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Date'
                    ]
                ]
            ]
        ]
    ];

    $query = http_build_query([
        'c' => json_encode($chartData),
        'format' => 'png',
        'width' => 600,
        'height' => 350,
        'backgroundColor' => 'white'
    ]);

    $image = file_get_contents("{$chartUrl}?{$query}");
    return base64_encode($image);
}

public function showPayment(Request $request)
{
    $selectedDate = $request->get('selected_date');
    $viewType = $request->get('view_type', 'month'); // 'day' or 'month'
    $date = $selectedDate ? \Carbon\Carbon::parse($selectedDate) : now();
    $month = $date->format('m');
    $year = $date->format('Y');

    // Get full range of month
    $monthStart = $date->copy()->startOfMonth()->format('Y-m-d');
    $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d');

    $weekStart = $date->copy()->startOfWeek()->format('Y-m-d');
    $weekEnd = $date->copy()->endOfWeek()->format('Y-m-d');

    // Dynamic summary statistics based on view type and selected date
    if ($selectedDate && $viewType === 'day') {
        // Summary for specific day (based on created_at)
       $summaryQuery = \App\Models\Payment::where(function ($query) use ($selectedDate) {
    $query->whereDate('paymentByParents_date', $selectedDate)
          ->orWhereNull('paymentByParents_date');
});

    } else {
        // Summary for month (based on created_at)
        $summaryQuery = \App\Models\Payment::whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
    }

    // Calculate summary statistics
    $totalCollected = (clone $summaryQuery)->where('payment_status', 'Complete')->sum('payment_amount');
    $paidCount = (clone $summaryQuery)->where('payment_status', 'Complete')->count();
    $unpaidCount = (clone $summaryQuery)->where('payment_status', 'Pending')->count();
    $overdueCount = (clone $summaryQuery)->where('payment_status', 'Overdue')->count();

    // Display ALL payment records for the selected date/period
    $paymentsQuery = \App\Models\Payment::with(['child', 'parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian']);

    if ($selectedDate && $viewType === 'day') {
        // Show payments created on specific date
        $payments = $paymentsQuery
    ->where(function ($query) use ($selectedDate) {
        $query->whereDate('paymentByParents_date', $selectedDate)
              ->orWhereNull('paymentByParents_date');
    })
    ->orderBy('payment_status')
    ->orderBy('created_at', 'desc')
    ->get();

            
    } else {
        // Show payments created in entire month
        $payments = $paymentsQuery->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('payment_status')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Trends using actual payment dates (for charts - keep monthly for consistency)
    $dailyTrend = \App\Models\Payment::selectRaw("DATE(paymentByParents_date) as period, COUNT(*) as total")
        ->whereBetween('paymentByParents_date', [$monthStart, $monthEnd])
        ->whereNotNull('paymentByParents_date')
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    $monthlyTrend = \App\Models\Payment::selectRaw("DATE_FORMAT(paymentByParents_date, '%Y-%m') as period, COUNT(*) as total")
        ->whereBetween('paymentByParents_date', [$monthStart, $monthEnd])
        ->whereNotNull('paymentByParents_date')
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    $weeklyTrend = \App\Models\Payment::selectRaw("YEAR(paymentByParents_date) as year, WEEK(paymentByParents_date, 1) as week, COUNT(*) as total")
        ->whereBetween('paymentByParents_date', [$weekStart, $weekEnd])
        ->whereNotNull('paymentByParents_date')
        ->groupBy('year', 'week')
        ->orderBy('year')
        ->orderBy('week')
        ->get();

    $selectedDate = $date->format('Y-m-d');

    return view('generateReports.paymentReport', compact(
        'selectedDate',
        'totalCollected',
        'paidCount',
        'unpaidCount',
        'overdueCount',
        'monthlyTrend',
        'weeklyTrend',
        'dailyTrend',
        'payments'
    ));
}




public function exportPDF(Request $request)
{
    $chartImage = $request->input('chartImage');
    $selectedDate = $request->input('selected_date');
    $viewType = $request->input('view_type', 'month');
    
    $date = $selectedDate ? \Carbon\Carbon::parse($selectedDate) : now();
    $month = $date->format('m');
    $year = $date->format('Y');

    // Dynamic summary statistics based on view type and selected date (same as web view)
    if ($selectedDate && $viewType === 'day') {
        // Summary for specific day
        $summaryQuery = \App\Models\Payment::where(function ($query) use ($selectedDate) {
            $query->whereDate('paymentByParents_date', $selectedDate)
                  ->orWhereNull('paymentByParents_date');
        });
        
        // Payments for specific day
        $payments = Payment::with('child', 'parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian')
            ->where(function ($query) use ($selectedDate) {
                $query->whereDate('paymentByParents_date', $selectedDate)
                      ->orWhereNull('paymentByParents_date');
            })
            ->orderBy('payment_status')
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // Summary for month
        $summaryQuery = \App\Models\Payment::whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
            
        // Payments for entire month
        $payments = Payment::with('child', 'parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('payment_status')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Calculate summary statistics (matching web view)
    $totalCollected = (clone $summaryQuery)->where('payment_status', 'Complete')->sum('payment_amount');
    $paidCount = (clone $summaryQuery)->where('payment_status', 'Complete')->count();
    $unpaidCount = (clone $summaryQuery)->where('payment_status', 'Pending')->count();
    $overdueCount = (clone $summaryQuery)->where('payment_status', 'Overdue')->count();
    
    $pdf = Pdf::loadView('generateReports.payment-pdf', compact(
        'chartImage', 
        'selectedDate', 
        'viewType',
        'payments', 
        'totalCollected', 
        'paidCount', 
        'unpaidCount', 
        'overdueCount'
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
