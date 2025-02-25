<?php

namespace App\Http\Controllers;

use App\Models\GenerateReport;
use Illuminate\Http\Request;

class GenerateReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('generateReports.attendanceReport');
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
}
