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


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$staffList = Staff::all();
        $staffList = Staff::with('user')->latest()->get();
       
        return view('staffs.index', compact('staffList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'staff_ic' => 'required|string',
            'staff_email' => 'required|email|unique:staff|unique:users,email',
            'staff_phoneno' => 'required|string',
            'staff_address' => 'nullable|string',
            'password' => 'required|min:8'
        ]);
    
        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::create([
                    'name' => $validatedData['staff_name'],
                    'email' => $validatedData['staff_email'],
                    'password' => Hash::make($validatedData['password']),
                    'role' => 'staff'
                ]);

                

                Staff::create([
                    'user_id' => $user->id,
                    'staff_name' => $validatedData['staff_name'],
                    'staff_ic' => $validatedData['staff_ic'],
                    'staff_email' => $validatedData['staff_email'],
                    'staff_phoneno' => $validatedData['staff_phoneno'],
                    'staff_address' => $validatedData['staff_address'] ?? null,
                ]);
            });
    
            return redirect()->route('staffs.index')->with('success', 'Staff registered successfully');
        } catch (\Exception $e) {
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
            'password' => 'nullable|min:8'
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
                    $userData['password'] = Hash::make($validatedData['password']);
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
