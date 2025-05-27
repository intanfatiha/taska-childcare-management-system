<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\staffAssignment;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $query = Staff::with('user');

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('staff_name', 'LIKE', "%{$search}%")
                  ->orWhere('staff_ic', 'LIKE', "%{$search}%")
                  ->orWhere('staff_email', 'LIKE', "%{$search}%")
                  ->orWhere('staff_phoneno', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'active') {
                $query->whereHas('user', function($q) {
                    $q->whereNotNull('email_verified_at');
                });
            } elseif ($request->status === 'inactive') {
                $query->whereHas('user', function($q) {
                    $q->whereNull('email_verified_at');
                });
            }
        }

        $staffList = $query->latest()->paginate(15);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            return response()->json([
                'data' => $staffList,
                'statistics' => $this->getStaffStatistics()
            ]);
        }

        return view('staffs.index', [
            'staffList' => $staffList,
            'search' => $request->search,
            'status' => $request->status,
            'statistics' => $this->getStaffStatistics()
        ]);
    }

    /**
     * Get staff statistics for dashboard
     */
    private function getStaffStatistics()
    {
        return [
            'total' => Staff::count(),
            'active' => Staff::whereHas('user', function($q) {
                $q->whereNotNull('email_verified_at');
            })->count(),
            'inactive' => Staff::whereHas('user', function($q) {
                $q->whereNull('email_verified_at');
            })->count(),
            'assigned' => StaffAssignment::distinct('primary_staff_id')->count(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staffs.create');
    }

   public function store(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'staff_name' => 'required|string|max:255',
        'staff_ic' => 'required|string',
        'staff_email' => 'required|email|unique:staff,staff_email|unique:users,email',
        'staff_phoneno' => 'required|string',
        'staff_address' => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Create user account
            $user = User::create([
                'name' => $validatedData['staff_name'],
                'email' => $validatedData['staff_email'],
                'password' => Hash::make($validatedData['staff_ic']), // Default password = IC
                'role' => 'staff',
            ]);

            // Create staff profile
            Staff::create([
                'user_id' => $user->id,
                'staff_name' => $validatedData['staff_name'],
                'staff_ic' => $validatedData['staff_ic'],
                'staff_email' => $validatedData['staff_email'],
                'staff_phoneno' => $validatedData['staff_phoneno'],
                'staff_address' => $validatedData['staff_address'] ?? null,
            ]);

            // Send email notification
            try {
                $loginUrl = route('login');
                Mail::html("
                    <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                        <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                            <h2 style='color: #2563eb; margin-bottom: 16px;'>👋 Welcome to Taska Hikmah!</h2>
                            <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                Hello {$validatedData['staff_name']},
                            </p>
                            <p style='color: #374151; margin-bottom: 16px;'>
                                Your staff account has been successfully created. Here are your login credentials:
                            </p>
                            <div style='background: #f3f4f6; padding: 16px; border-radius: 8px; margin: 16px 0;'>
                                <p style='margin: 4px 0; color: #374151;'><strong>Email:</strong> {$validatedData['staff_email']}</p>
                                <p style='margin: 4px 0; color: #374151;'><strong>Password:</strong> Identity Card Number</p>
                            </div>
                            <p style='color: #374151; margin-bottom: 24px;'>
                                You can now log in to the system using the button below:
                            </p>
                            <div style='text-align: center; margin-bottom: 24px;'>
                                <a href='{$loginUrl}' style='display: inline-block; background: #2563eb; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;'>
                                    🔑 Login to System
                                </a>
                            </div>
                            <p style='color: #dc2626; font-size: 14px; margin-bottom: 24px;'>
                                ⚠️ Please change your password after logging in to ensure your account's security.
                            </p>
                            <p style='color: #9ca3af; font-size: 13px; margin-top: 32px;'>
                                This is an automated email from Taska Childcare Management System.
                            </p>
                        </div>
                    </div>
                ", function ($message) use ($validatedData) {
                    $message->to($validatedData['staff_email'])
                            ->subject('Your Taska Hikmah Staff Account is Ready!');
                });

                Log::info("Staff registration email sent to: {$validatedData['staff_email']}");
            } catch (\Exception $e) {
                Log::error("Failed to send staff email. Error: " . $e->getMessage());
            }
        });

        return redirect()->route('staffs.index')->with('success', 'Staff registered and email sent successfully.');

    } catch (\Exception $e) {
        Log::error("Staff registration failed. Error: " . $e->getMessage());
        return back()->with('error', 'Error registering staff: ' . $e->getMessage())->withInput();
    }
}



    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
        return view('staffs.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        \Log::info('Update request data:', $request->all());
        //
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'staff_ic' => 'required|string',
            'staff_email' => 'required|email|unique:staff,staff_email,' . $staff->id . '|unique:users,email,' . $staff->user_id,
            'staff_phoneno' => 'required|string',
            'staff_address' => 'nullable|string',
        ]);
    
        try {
            DB::transaction(function () use ($validatedData, $staff) {
                // Update the associated User record
                $user = $staff->user;
                
                $userData = [
                    'name' =>$validatedData['staff_name'],
                    'email' => $validatedData['staff_email'],
                ];

                if (!empty($validatedData['password'])) {
                    $userData['password'] = Hash::make($validatedData['staff_ic']);
                }
                
                $user->update($userData);
    
                // Update the Staff record
                $staff->update([
                    'staff_name' => $validatedData['staff_name'],
                    'staff_ic' => $validatedData['staff_ic'],
                    'staff_email' => $validatedData['staff_email'],
                    'staff_phoneno' => $validatedData['staff_phoneno'],
                    'staff_address' => $validatedData['staff_address'] ?? $staff->staff_address,
                ]);
            });
    
            return redirect()->route('staffs.index')->with('success', 'Staff updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating staff: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
        try {
            DB::transaction(function () use ($staff) {
                // Delete the associated User record
                $user = $staff->user;
                $user->delete();
    
                // Delete the Staff record
                $staff->delete();
            });
    
            return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting staff: ' . $e->getMessage());
        }
    }


    public function staffAssignment()
    {
        // $childrens = Child::findOrFail($childrenId);
        $childrens = Child::all();
        $staffs = Staff::all();

        foreach ($childrens as $child) {
            $assignment = StaffAssignment::where('child_id', $child->id)->first();
            if ($assignment) {
                $child->assigned_staff_id = $assignment->staff_id;
                $child->status = $assignment->status;
            } else {
                $child->assigned_staff_id = null;
                $child->status = 'no status';
            }
        }
        return view('staffs.assign', compact('childrens','staffs'));
      
    }

    public function updateAssignments(Request $request)
    {
        $request->validate([
            'primary_staff' => 'nullable|array',
            'primary_staff.*' => 'nullable|exists:staff,id',
            'status' => 'nullable|array',
            'status.*' => 'nullable|in:active,offday,no status',
        ]);
    
        try {
            DB::beginTransaction();
    
            if ($request->has('primary_staff')) {
                foreach ($request->primary_staff as $childId => $staffId) {
                    $status = $request->status[$childId] ?? 'no status';
    
                    // If no staff selected, delete any assignment
                    if (is_null($staffId) || $staffId === '') {
                        // StaffAssignment::where('child_id', $childId)->delete();
                        continue;
                    }
    
                    // Update or create assignment
                    StaffAssignment::updateOrCreate(
                        ['child_id' => $childId],
                        [
                            'primary_staff_id' => $staffId, 
                            'status' => $status
                        ]
                    );
                }
            }
    
            DB::commit();
            return redirect()->route('staffs.staffAssignment')->with('success', 'Staff assignments updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }
    

}
