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
        $date = $request->get('date', now()->format('d-m-Y')); // Default to today's date

        $children = Child::with(['attendances' => function ($query) use ($date) {
            $query->where('attendance_date', $date);
        }])->get();

        $totalAttend = Attendance::where('attendance_date', $date)->where('attendance_status', 'attend')->count();
        $totalAbsent = Attendance::where('attendance_date', $date)->where('attendance_status', 'absent')->count();
    
        return view('attendances.index', compact('children', 'date', 'totalAttend', 'totalAbsent'));    
    }

    public function parentsIndex(Request $request)
    {
        $userId = auth()->id();
        $parent = \App\Models\ParentRecord::where('user_id', $userId)->first();

        if (!$parent) {
            return redirect()->route('dashboard')->with('error', 'Parent record not found.');
        }

        // Get all children of the parent
        $myChildren = \App\Models\Child::where('parent_id', $parent->id)->get();

        // Get the selected date or default to today
        $filterDate = $request->get('date', now()->format('Y-m-d'));

        // Calculate attendance summary
        $totalChildren = $myChildren->count();
        $presentToday = 0;
        $absentToday = 0;

        foreach ($myChildren as $child) {
            $attendance = \App\Models\Attendance::where('child_id', $child->id)
                ->where('attendance_date', $filterDate)
                ->first();

            if ($attendance && $attendance->attendance_status === 'attend') {
                $presentToday++;
            } elseif ($attendance && $attendance->attendance_status === 'absent') {
                $absentToday++;
            }
        }

        return view('attendances.parentsIndex', compact('myChildren', 'filterDate', 'totalChildren', 'presentToday', 'absentToday'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = now()->format('Y-m-d'); // Get today's date
        $children = Child::with(['attendances' => function ($query) use ($date) {
            $query->where('attendance_date', $date);
        }])->paginate(30);


        return view('attendances.create',compact('children','date'));
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
                        //If the child is marked as "absent," these fields should be set to NULL.
                        'attendance_status' => $status,
                        'time_in' => $status === 'attend' ? ($validated['time_in'][$childId] ?? null) : null,
                        'time_out' => $status === 'attend' ? ($validated['time_out'][$childId] ?? null) : null,
                    ]
                );
            }
        
            return redirect()->route('attendances.index')->with('success', 'Attendance saved successfully!');
        
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
