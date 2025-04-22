<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        //
        // $date = $request->get('date', now()->format('Y-m-d'));
        // $children = Attendance::where('attendance_date', $date)
        // ->with('child')
        // ->get();

        // $children = Child::with('enrollment')
        //     ->whereHas('enrollment', function ($query) {
        //         $query->where('status', 'active');
        //     })
        //     ->get();

        $children = Child::all();

        return view('attendances.index', compact('children'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('attendances.create');
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
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
