<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ParentRecord;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        // Find all ParentRecords where the logged-in user is a father, mother, or guardian
        $parentRecords = \App\Models\ParentRecord::where(function ($query) use ($userId) {
            $query->where('father_id', $userId)
                ->orWhere('mother_id', $userId)
                ->orWhere('guardian_id', $userId);
        })->with('child')->get();

        // Get all children associated with the parent
        $myChildren = $parentRecords->pluck('child');

        // Get the selected date or default to today
        $filterDate = $request->get('date', now()->format('Y-m-d'));

        // Calculate attendance summary
        $totalChildren = $myChildren->count();
        $presentToday = 0;
        $absentToday = 0;

        foreach ($myChildren as $child) {
            $attendance = \App\Models\Attendance::where('children_id', $child->id)
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
        $attendance = Attendance::updateOrCreate(
            [
                'children_id' => $childId,
                'attendance_date' => $attendanceDate,
            ],
            [
                'attendance_status' => $status,
                'time_in' => $status === 'attend' ? ($validated['time_in'][$childId] ?? now()->format('H:i:s')) : null,
                'time_out' => $status === 'attend' ? ($validated['time_out'][$childId] ?? null) : null,
            ]
        );

        // Send email to parents only if the child attended
        if ($status === 'attend') {
            $child = \App\Models\Child::find($childId); // Retrieve the child's details

            // Retrieve parent IDs (father, mother, guardian)
            $parents = \App\Models\ParentRecord::where('child_id', $childId)
                ->select('father_id', 'mother_id', 'guardian_id')
                ->first();

            if ($parents) {
                $parentIds = [$parents->father_id, $parents->mother_id, $parents->guardian_id];

                // Retrieve users with the parents role
                $parentUsers = User::whereIn('id', $parentIds)
                    ->where('role', 'parents')
                    ->get();

                    dd([
                        'Child ID' => $childId,
                        'Father ID' => $parents->father_id,
                        'Mother ID' => $parents->mother_id,
                        'Guardian ID' => $parents->guardian_id,
                    ]);
                foreach ($parentUsers as $parentUser) {
                    try {
                        $htmlContent = "
                            <h2>Dear {$parentUser->name},</h2>
                            <p>We hope this message finds you well.</p>
                            <p>Please be informed that your child has attended Taska Hikmah with the following details:</p>
                            <p><strong>Child Name:</strong> {$child->child_name}</p>
                            <p><strong>Date:</strong> {$attendanceDate}</p>
                            <p><strong>Time-In:</strong> {$attendance->time_in}</p>
                            <p><strong>Time-Out:</strong> " . ($attendance->time_out ?? 'Not yet checked out') . "</p>
                            <p>Warm regards,<br>
                            Taska Hikmah</p>
                            <hr>
                            <p style=\"font-size: 0.9em; color: #555;\">
                            <p>This is an automated message. Please do not reply to this email.</p>
                            For any inquiries, please contact us or call us at 07-1234567.<br>
                            </p>
                        ";

                        Mail::send([], [], function ($message) use ($parentUser, $htmlContent) {
                            $message->to($parentUser->email)
                                    ->subject('Attendance Information From Taska Hikmah')
                                    ->html($htmlContent);
                        });

                        Log::info("Attendance email sent successfully to: {$parentUser->email}");
                    } catch (\Exception $e) {
                        Log::error("Failed to send attendance email to {$parentUser->email}. Error: " . $e->getMessage());
                    }
                }
            }
        }
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
