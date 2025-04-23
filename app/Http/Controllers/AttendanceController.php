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
        $date = $request->get('date', now()->format('Y-m-d')); // Default to today's date
        $children = Child::with(['attendances' => function ($query) use ($date) {
            $query->where('attendance_date', $date);
        }])->get();

        return view('attendances.index', compact('children', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $children = Child::paginate(30);
        return view('attendances.create',compact('children'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $validated = $request->validate([
                'status' => 'required|array',
                'status.*' => 'required|in:attend,absent',
                'time_in' => 'nullable|array',
                'time_in.*' => 'nullable|date_format:H:i',
                'time_out' => 'nullable|array',
                'time_out.*' => 'nullable|date_format:H:i',
            ]);
    
            $attendanceDate = now()->format('Y-m-d'); // Use today's date for attendance

            foreach ($validated['status'] as $childId => $status) {
                Attendance::updateOrCreate(
                    [
                        'children_id' => $childId,
                        'attendance_date' => $attendanceDate,
                    ],
                    [
                        'attendance_status' => $status, // Use 'present' or 'absent' directly
                        'time_in' => $validated['time_in'][$childId] ?? null,
                        'time_out' => $validated['time_out'][$childId] ?? null,
                    ]
                );
            }
        
            return redirect()->route('attendances.create')->with('success', 'Attendance saved successfully!');
        
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

   
    public function showCheckInForm()
    {
        $children = Child::all();
        return view('attendances.timeIn', compact('children'));
    }

public function checkIn(Request $request)
{
    $validated = $request->validate([
        'children_id' => 'required|exists:children,id',
        'attendance_date' => 'required|date',
    ]);

    // Check if the child already has a record for the day
    $attendance = Attendance::where('children_id', $validated['children_id'])
        ->where('attendance_date', $validated['attendance_date'])
        ->first();

    if ($attendance) {
        return redirect()->route('attendances.index')->with('error', 'Child has already checked in today.');
    }

    // Create a new attendance record with check-in time
    Attendance::create([
        'children_id' => $validated['children_id'],
        'attendance_date' => $validated['attendance_date'],
        'time_in' => now()->format('H:i:s'),
        'attendance_status' => 'Checked In',
    ]);

    return redirect()->route('attendances.index')->with('success', 'Check In successful!');
}

public function checkOut(Request $request)
{
    $validated = $request->validate([
        'children_id' => 'required|exists:children,id',
        'attendance_date' => 'required|date',
    ]);

    // Find the attendance record for the child and date
    $attendance = Attendance::where('children_id', $validated['children_id'])
        ->where('attendance_date', $validated['attendance_date'])
        ->first();

    if (!$attendance) {
        return redirect()->route('attendances.index')->with('error', 'No check-in record found for this child today.');
    }

    if ($attendance->time_out) {
        return redirect()->route('attendances.index')->with('error', 'Child has already checked out today.');
    }

    // Update the attendance record with check-out time
    $attendance->update([
        'time_out' => now()->format('H:i:s'),
        'attendance_status' => 'Checked Out',
    ]);

    return redirect()->route('attendances.index')->with('success', 'Check Out successful!');
}
}
