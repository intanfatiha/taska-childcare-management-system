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
use Barryvdh\DomPDF\Facade\Pdf;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $date = $request->get('date', now()->format('Y-m-d')); // Default to today's date

        $children = Child::whereHas('enrollment', function($query) {
            $query->where('status', 'approved');
        })->with(['enrollment', 'attendances' => function ($query) use ($date) {
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

         $child = \App\Models\Child::find($childId);
        $parentRecord = \App\Models\ParentRecord::where('child_id', $childId)->first();

    $parentEmails = [];
    if ($parentRecord) {
        if ($parentRecord->father_id) {
            $father = \App\Models\Father::find($parentRecord->father_id);
            if ($father && $father->email) $parentEmails[] = $father->email;
                    \Log::info('Father email for child ID ' . $childId . ': ' . $father->email);

        }
        if ($parentRecord->mother_id) {
            $mother = \App\Models\Mother::find($parentRecord->mother_id);
            if ($mother && $mother->email) $parentEmails[] = $mother->email;
            \Log::info('Mother email for child ID ' . $childId . ': ' . $mother->email);
        }
        if ($parentRecord->guardian_id) {
            $guardian = \App\Models\Guardian::find($parentRecord->guardian_id);
            if ($guardian && $guardian->email) $parentEmails[] = $guardian->email;
            \Log::info('Guardian email for child ID ' . $childId . ': ' . $guardian->email);
        }
    }

    // Only send email if "attend" or time_out is set
    if ($status === 'attend' || !empty($validated['time_out'][$childId])) {
        $childName = $child->child_name ?? 'Your child';
        $attendanceTime = $status === 'attend'
            ? (!empty($validated['time_in'][$childId]) ? date('g:i A', strtotime($validated['time_in'][$childId])) : now()->format('g:i A'))
            : (!empty($validated['time_out'][$childId]) ? date('g:i A', strtotime($validated['time_out'][$childId])) : now()->format('g:i A'));
        $attendanceType = $status === 'attend' ? 'checked in' : 'checked out';

        foreach ($parentEmails as $email) {
            try {
                \Mail::html("
                    <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                        <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                            <h2 style='color: #2563eb; margin-bottom: 16px;'>Attendance Notification</h2>
                            <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                $childName has <strong>$attendanceType</strong> on <strong>$attendanceDate</strong> at <strong>$attendanceTime</strong>.
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
                ", function ($message) use ($email, $childName, $attendanceType) {
                    $message->to($email)
                        ->subject("Attendance Update: $childName $attendanceType");
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

   
   
    // public function showCheckInForm()
    // {
    //     $children = Child::all();
    //     return view('attendances.timeIn', compact('children'));
    // }

   

   
}
