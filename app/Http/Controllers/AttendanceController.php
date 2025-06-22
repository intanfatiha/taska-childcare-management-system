<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\User;
use App\Models\ParentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $date = $request->get('date', now()->format('Y-m-d')); // Default to today's date
            $search = $request->get('search'); // Get search term

 $childrenQuery = Child::whereHas('enrollment', function($query) {
        $query->where('status', 'approved');
    });

    // Add search filter for child name
    if ($search) {
        $childrenQuery->where('child_name', 'like', '%' . $search . '%');
    }

    $children = $childrenQuery->with(['enrollment', 'attendances' => function ($query) use ($date) {
        $query->where('attendance_date', $date);
    }])->get();

        // Get the total number of children
        $totalChildren = Child::whereHas('enrollment', function($query) {
            $query->where('status', 'approved');
        })->count();
        $totalAttend = Attendance::where('attendance_date', $date)->where('attendance_status', 'attend')->count();
        $totalAbsent = Attendance::where('attendance_date', $date)->where('attendance_status', 'absent')->count();
    
        return view('attendances.index', compact('children', 'date', 'totalChildren', 'totalAttend', 'totalAbsent'));    
    }

   

public function parentsIndex(Request $request)
{
    $date = $request->get('date', now()->format('Y-m-d'));
    $userId = auth()->id();

    // Find parent/guardian records for this user
    $father = \App\Models\Father::where('user_id', $userId)->first();
    $mother = \App\Models\Mother::where('user_id', $userId)->first();
    $guardian = \App\Models\Guardian::where('user_id', $userId)->first();

    // Collect all possible parent/guardian IDs
    $fatherId = $father?->id;
    $motherId = $mother?->id;
    $guardianId = $guardian?->id;

    // Find ParentRecords where this user is a father, mother, or guardian
    $parentRecords = \App\Models\ParentRecord::query()
        ->when($fatherId, fn($q) => $q->orWhere('father_id', $fatherId))
        ->when($motherId, fn($q) => $q->orWhere('mother_id', $motherId))
        ->when($guardianId, fn($q) => $q->orWhere('guardian_id', $guardianId))
        ->with('child')
        ->get();

    // Get all children associated with the parent, filter out nulls, and unique by id
    $myChildren = $parentRecords->pluck('child')->filter()->unique('id')->values();

    $filterDate = $request->get('date', now()->format('Y-m-d'));

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
        $children = Child::whereHas('enrollment', function($query) {
            $query->where('status', 'approved');
        })->with(['attendances' => function ($query) use ($date) {
            $query->where('attendance_date', $date);
        }])->paginate(30);

        return view('attendances.create', compact('children', 'date'));
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
                    'time_out' => null, // Always set time_out to null
                ]
            );


        // Get child and parent data
        $child = Child::find($childId);
        $parentRecord = ParentRecord::with(['father', 'mother', 'guardian'])
            ->where('child_id', $childId)
            ->first();
    

            $parentEmails = [];
            if ($parentRecord) {
                if ($parentRecord->father && $parentRecord->father->father_email) {
                    $parentEmails[] = $parentRecord->father->father_email;
                }
                if ($parentRecord->mother && $parentRecord->mother->mother_email) {
                    $parentEmails[] = $parentRecord->mother->mother_email;
                }
                if ($parentRecord->guardian && $parentRecord->guardian->guardian_email) {
                    $parentEmails[] = $parentRecord->guardian->guardian_email;
                }
            }

            // dd($parentEmails);

            // Send email notification for attendance (both present and absent)
            if (!empty($parentEmails)) {
                $childName = $child->child_name ?? 'Your child';
                
                if ($status === 'attend') {
                    $timeIn = !empty($validated['time_in'][$childId]) 
                        ? date('g:i A', strtotime($validated['time_in'][$childId])) 
                        : now()->format('g:i A');
                    $message = "$childName has <strong>checked in</strong> on <strong>$attendanceDate</strong> at <strong>$timeIn</strong>.";
                    $subject = "Check-in Notification: $childName arrived";
                } else {
                    $message = "$childName has been marked as <strong>absent</strong> on <strong>$attendanceDate</strong>.";
                    $subject = "Attendance Notification: $childName absent";
                }

                foreach ($parentEmails as $email) {
                    try {
                        \Mail::html("
                            <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                                <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                                    <h2 style='color: #2563eb; margin-bottom: 16px;'>Attendance Notification</h2>
                                    <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                        $message
                                    </p>
                                    <p style='color: #374151; margin-bottom: 24px;'>
                                        Please log in to your account for more details.
                                    </p>
                                    <a href='" . route('login') . "' style='display: inline-block; background: #2563eb; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;'>
                                        🔑 Login to Parent Portal
                                    </a>
                                    <p style='color: #9ca3af; font-size: 13px; margin-top: 32px;'>
                                        This is an automated notification from Taska Childcare Management System.
                                    </p>
                                </div>
                            </div>
                        ", function ($message) use ($email, $subject) {
                            $message->to($email)->subject($subject);
                        });
                    } catch (\Exception $e) {
                        \Log::error("Failed to send attendance email to $email. Error: " . $e->getMessage());
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

     public function edit($childId, $date= null)
    {
        $date = $date ?? now()->format('Y-m-d');
    
        // Get the child
        $child = Child::findOrFail($childId);
        
        // Get existing attendance record for this child and date
        $attendance = Attendance::where('children_id', $childId)
                            ->where('attendance_date', $date)
                            ->first();
        
        return view('attendances.edit', compact('child', 'attendance', 'date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $childId, $date = null)
    {
        $date = $date ?? $request->input('attendance_date', now()->format('Y-m-d'));

        $validatedData = $request->validate([
            'attendance_status' => 'required|in:attend,absent',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'attendance_date' => 'required|date',
        ]);

        if ($validatedData['attendance_status'] === 'attend' && empty($validatedData['time_in'])) {
            return back()->withErrors(['time_in' => 'Time In is required when marking attendance as Present.']);
        }

        if ($validatedData['attendance_status'] === 'absent') {
            $validatedData['time_in'] = null;
            $validatedData['time_out'] = null;
        }

        $attendance = Attendance::updateOrCreate(
            [
                'children_id' => $childId,
                'attendance_date' => $validatedData['attendance_date']
            ],
            [
                'attendance_status' => $validatedData['attendance_status'],
                'time_in' => $validatedData['time_in'],
                'time_out' => $validatedData['time_out'],
            ]
        );

        if (!empty($validatedData['time_out'])) {
            $attendanceDate = \Carbon\Carbon::parse($validatedData['attendance_date']);
            $dayOfWeek = $attendanceDate->format('l');
            $threshold = ($dayOfWeek === 'Thursday') ? '16:00' : '17:30';

            $closeTime = \Carbon\Carbon::parse($validatedData['attendance_date'] . ' ' . $threshold);
            $outTime = \Carbon\Carbon::parse($validatedData['attendance_date'] . ' ' . $validatedData['time_out']);

            $overtimeMinutes = 0;
            if ($outTime->gt($closeTime)) {
                $overtimeMinutes = $outTime->diffInMinutes($closeTime);
            }

            $attendance->attendance_overtime = $overtimeMinutes;
            $attendance->save();
        }

        return redirect()->route('attendances.index', ['date' => $validatedData['attendance_date']])
            ->with('success', 'Attendance updated successfully for ' . $attendance->child->child_name);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

   
   
    // public function showCheckInForm()
    // {
    //     $children = Child::all();
    //     return view('attendances.timeIn', compact('children'));
    // }




// Add these methods to your AttendanceController

/**
 * Show the time out form (only children who are present today)
 */
public function createTimeOut(Request $request) 
{
    // Use selected date from request, or default to today
    $date = $request->get('date', now()->format('Y-m-d'));

    // Get present children with attendance on the selected date
    $presentChildren = \App\Models\Child::whereHas('attendances', function ($query) use ($date) {
        $query->where('attendance_date', $date)
              ->where('attendance_status', 'attend');
    })
    ->with(['attendances' => function ($query) use ($date) {
        $query->where('attendance_date', $date);
    }])->get();

    // Get absent children (if needed)
    $absentChildren = \App\Models\Child::whereHas('attendances', function ($query) use ($date) {
        $query->where('attendance_date', $date)
              ->where('attendance_status', 'absent');
    })
    ->with(['attendances' => function ($query) use ($date) {
        $query->where('attendance_date', $date);
    }])->get();

    // Total stats (if needed)
    $totalChildren = \App\Models\Child::count(); 
    $totalAttend = $presentChildren->count();
    $totalAbsent = $absentChildren->count();

    // Return the view with filtered data
    return view('attendances.createTimeOut', compact('presentChildren', 'date', 'totalChildren', 'totalAttend', 'totalAbsent'));
}


public function updateTimeOut(Request $request)
{
    $request->validate([
        'time_out' => 'required|array',
        'time_out.*' => 'nullable|date_format:H:i',
    ]);

    $today = now()->format('Y-m-d');
    $updatedCount = 0;

    foreach ($request->time_out as $childId => $timeOut) {
        if (!empty($timeOut)) {
            $attendance = Attendance::where('children_id', $childId)
                ->where('attendance_date', $today)
                ->where('attendance_status', 'attend')
                ->first();

            if ($attendance) {
                $attendanceDate = \Carbon\Carbon::parse($attendance->attendance_date);
                $dayOfWeek = $attendanceDate->format('l'); // e.g. 'Monday'
                $threshold = ($dayOfWeek === 'Thursday') ? '16:00' : '17:30';

                // Calculate overtime minutes
                $closeTime = \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $threshold);
                $outTime = \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $timeOut);
                $overtimeMinutes = 0;
                if ($outTime->gt($closeTime)) {
                    $overtimeMinutes = $outTime->diffInMinutes($closeTime);
                }

                $attendance->time_out = $timeOut;
                $attendance->attendance_overtime = $overtimeMinutes;
                $attendance->save();

                $updatedCount++;

                // Get child and parent data
                $child = Child::find($childId);
                $parentRecord = ParentRecord::with(['father', 'mother', 'guardian'])
                    ->where('child_id', $childId)
                    ->first();

                $parentEmails = [];
                if ($parentRecord) {
                    if ($parentRecord->father && $parentRecord->father->father_email) {
                        $parentEmails[] = $parentRecord->father->father_email;
                    }
                    if ($parentRecord->mother && $parentRecord->mother->mother_email) {
                        $parentEmails[] = $parentRecord->mother->mother_email;
                    }
                    if ($parentRecord->guardian && $parentRecord->guardian->guardian_email) {
                        $parentEmails[] = $parentRecord->guardian->guardian_email;
                    }
                }

                // Send email notification (check-out only)
                if (!empty($parentEmails)) {
                    $childName = $child->child_name ?? 'Your child';
                    $outTimeFormatted = date('g:i A', strtotime($timeOut));
                    $attendanceDateFormatted = $attendanceDate->format('F j, Y');

                    $message = "$childName has <strong>checked out</strong> on <strong>$attendanceDateFormatted</strong> at <strong>$outTimeFormatted</strong>.";
                    $subject = "Check-Out Notification: $childName Checked Out";

                    foreach ($parentEmails as $email) {
                        try {
                            \Mail::html("
                                <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                                    <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                                        <h2 style='color: #2563eb; margin-bottom: 16px;'>Attendance Notification</h2>
                                        <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                            $message
                                        </p>
                                        <p style='color: #374151; margin-bottom: 24px;'>
                                            Please log in to your account for more details.
                                        </p>
                                        <a href='" . route('login') . "' style='display: inline-block; background: #2563eb; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;'>
                                            🔑 Login to Parent Portal
                                        </a>
                                        <p style='color: #9ca3af; font-size: 13px; margin-top: 32px;'>
                                            This is an automated notification from Taska Childcare Management System.
                                        </p>
                                    </div>
                                </div>
                            ", function ($message) use ($email, $subject) {
                                $message->to($email)->subject($subject);
                            });
                        } catch (\Exception $e) {
                            \Log::error("Failed to send attendance email to $email. Error: " . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    return redirect()->route('attendances.index')->with('success', "Time out updated for {$updatedCount} children.");
}


/**
 * Send time out notification to parents
 */
private function sendTimeOutNotification($childId, $timeOut, $attendanceDate)
{
    try {
        $child = \App\Models\Child::find($childId);
        $parentRecord = ParentRecord::with(['father', 'mother', 'guardian'])
            ->where('child_id', $childId)->first();

        $parentEmails = [];
        if ($parentRecord) {
            if ($parentRecord->father && $parentRecord->father->email) {
                $parentEmails[] = $parentRecord->father->email;
            }
            if ($parentRecord->mother && $parentRecord->mother->email) {
                $parentEmails[] = $parentRecord->mother->email;
            }
            if ($parentRecord->guardian && $parentRecord->guardian->email) {
                $parentEmails[] = $parentRecord->guardian->email;
            }
        }

        if (!empty($parentEmails)) {
            $childName = $child->child_name ?? 'Your child';
            $timeOutFormatted = date('g:i A', strtotime($timeOut));
            $subject = "Check-out Notification: $childName departed";
            $message = "$childName has <strong>checked out</strong> on <strong>$attendanceDate</strong> at <strong>$timeOutFormatted</strong>.";

            foreach ($parentEmails as $email) {
                \Mail::html("
                    <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                        <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                            <h2 style='color: #dc2626; margin-bottom: 16px;'>🏠 Check-out Notification</h2>
                            <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                $message
                            </p>
                            <div style='background: #fef2f2; border-left: 4px solid #dc2626; padding: 12px; margin: 16px 0; border-radius: 4px;'>
                                <p style='color: #dc2626; margin: 0; font-weight: bold;'>
                                    <i class='fas fa-clock'></i> Departure Time: $timeOutFormatted
                                </p>
                            </div>
                            <p style='color: #374151; margin-bottom: 24px;'>
                                Please log in to your account for more details.
                            </p>
                            <a href='" . route('login') . "' style='display: inline-block; background: #dc2626; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;'>
                                🔑 Login to Parent Portal
                            </a>
                            <p style='color: #9ca3af; font-size: 13px; margin-top: 32px;'>
                                This is an automated notification from Taska Childcare Management System.
                            </p>
                        </div>
                    </div>
                ", function ($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                });
            }
        }
    } catch (\Exception $e) {
        \Log::error("Failed to send time out notification for child ID $childId. Error: " . $e->getMessage());
    }
}
   

   
}
