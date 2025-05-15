<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\GenerateReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class GenerateReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Get the selected date or default to today's date
        $selectedDate = $request->input('selected_date', now()->format('Y-m-d'));

        // Fetch attendance data for the selected date
        $attendances = Attendance::with('child')
            ->where('attendance_date', $selectedDate)
            ->get();

        return view('generateReports.attendanceReport', compact('attendances', 'selectedDate'));
    
    }

    public function showPayment()
    {
        //
        return view('generateReports.paymentReport');
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
