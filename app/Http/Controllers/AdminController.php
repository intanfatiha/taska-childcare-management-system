<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\User;
use App\Models\ParentRecord;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('adminHomepage');
    }

    public function listEnrollments()
{
    $children = Child::whereHas('enrollment', function($query) {
            $query->where('status', 'approved');
        })
        ->with(['enrollment', 'parentRecords.father', 'parentRecords.mother', 'parentRecords.guardian'])
        ->paginate(15);


    return view('adminActivity.listChildEnrollment', compact('children'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         

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
    // public function show( $id)
    // {
    //     //
    //     $user = auth()->user();
    //     $enrollment = Enrollment::with(['father','mother','guardian','child'])->findorFail($id);
    //     return view('adminActivity.enrollmentDetail', compact('enrollment','user'));
     

    // }

    public function show(Enrollment $adminActivity)
    {
        $user = auth()->user();
        $enrollment = $adminActivity->load([
            'father', 'mother', 'guardian', 'child.parentRecords.father', 'child.parentRecords.mother', 'child.parentRecords.guardian'
        ]);
        return view('adminActivity.enrollmentDetail', compact('enrollment', 'user'));
    }
 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parentRecord = ParentRecord::findOrFail($id);

        $enrollment = Enrollment::where("id", $parentRecord->enrollment_id)->delete();
        $father = Father::where("id", $parentRecord->father_id)->delete();
        $mother = Mother::where("id", $parentRecord->mother_id)->delete();
        $guardian = Guardian::where("id", $parentRecord->guardian_id)->delete();
        $child = Child::where("id", $parentRecord->child_id)->delete();
        $parentRecord->delete();
    
        return redirect()->route('childrenRegisterRequest')->with('message', 'Enrollment deleted successfully.');
    
    }

    

    public function childrenRegisterRequest(Request $request)
{
    $status = $request->query('status', 'request'); // default to 'request'

    // Query ParentRecord, eager load all relationships, and filter by enrollment status
    $parentRecords = \App\Models\ParentRecord::with(['father', 'mother', 'guardian', 'child', 'enrollment'])
        ->whereHas('enrollment', function($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate(10);
    

    return view('adminActivity.childRegisterRequest', [
        'parentRecords' => $parentRecords,
        'status' => $status,
    ]);
}


    public function approveRegistrationForm($enrollmentId) 
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        return view('adminActivity.approve', compact('enrollment'));
    }

 

    public function rejection()
    {
        return view('adminActivity.reject');
        //return 'Test: Route and Controller are working.';
    }

    public function rejectRegistration(Request $request, $parentRecordId)
    {   
        $validated = $request->validate([
            'father_email' => 'nullable|email',
            'mother_email' => 'nullable|email',
            'guardian_email' => 'nullable|email',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'registration_type' => 'required|string|in:parents,guardian',
            'rejectReason' => 'required|string|max:255',
        ]);

        // $enrollment = Enrollment::findOrFail($enrollmentId);

         $validated['registration_type'] = $validated['registration_type'] ?? 'parents';
 
        // Find ParentRecord and related models
        $parentRecord = \App\Models\ParentRecord::with(['enrollment', 'father', 'mother', 'guardian', 'child'])->findOrFail($parentRecordId);

        $enrollment = $parentRecord->enrollment;
        $father = $parentRecord->father;
        $mother = $parentRecord->mother;
        $guardian = $parentRecord->guardian;
        $child = $parentRecord->child;

        // Update the enrollment status to "approved"
        if ($enrollment) {
            $enrollment->status = 'rejected';
            $enrollment->save();
        }

        

        // // Update the enrollment status to "rejected"
        // $enrollment->status = 'rejected';
        // $enrollment->save();

        // Collect emails to send the rejection message
        $emails = [];
        if (!empty($father?->father_email)) {
            $emails[$father->father_email] = $father->father_name;
        }
        if (!empty($mother?->mother_email)) {
        $emails[$mother->mother_email] = $mother->mother_name;
        }

        if (!empty($guardian?->guardian_email)) {
            $emails[$guardian->guardian_email] = $guardian->guardian_name;
        }

            // Send rejection emails
         foreach ($emails as $email => $name) {
        try {
            Mail::html("
                <div style=\"font-family: Arial, sans-serif; padding: 20px; background-color: #f8f8f8;\">
                    <div style=\"max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);\">
                        <h2 style=\"color: #cc0000;\">Dear $name,</h2>
                        <p>We regret to inform you that your childcare registration for <strong>{$child?->full_name}</strong> has been <span style=\"color: #cc0000;\"><strong>rejected</strong></span>.</p>
                        <p><strong>Reason for rejection:</strong><br>{$validated['rejectReason']}</p>
                        <p>If you have any questions, please contact us for further clarification.</p>
                        <p>Thank you for your interest in our childcare services.</p>
                        <br>
                        <p style=\"font-size: 14px; color: #888;\">This is an automated email. Please do not reply directly to this message.</p>
                    </div>
                </div>
            ", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Childcare Registration Rejected');
            });

            Log::info("Rejection email sent successfully to: $email");
        } catch (\Exception $e) {
            Log::error("Failed to send rejection email to $email. Error: " . $e->getMessage());
        }
    }


       $sharedChildren = ParentRecord::where('father_id', $parentRecord->father_id)
    ->orWhere('mother_id', $parentRecord->mother_id)
    ->orWhere('guardian_id', $parentRecord->guardian_id)
    ->orWhere('enrollment_id', $parentRecord->enrollment_id)
    ->where('id', '!=', $parentRecord->id) // exclude current
    ->exists();

    if (!$sharedChildren) {
        Enrollment::where("id", $parentRecord->enrollment_id)->delete();
        Father::where("id", $parentRecord->father_id)->delete();
        Mother::where("id", $parentRecord->mother_id)->delete();
        Guardian::where("id", $parentRecord->guardian_id)->delete();
    }

    Child::where("id", $parentRecord->child_id)->delete();
    $parentRecord->delete();



        // Redirect back with a success message
        return redirect()->route('childrenRegisterRequest')->with('message', 'Application rejected successfully.');



    }

    //To register parents/guardian account
    public function approveRegistration(Request $request, $parentRecordId)
    {
        // Validate inputs
        $validated = $request->validate([
            'father_email' => 'nullable|email',
            'mother_email' => 'nullable|email',
            'guardian_email' => 'nullable|email',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'father_ic' => 'nullable|string|max:20',
            'mother_ic' => 'nullable|string|max:20',
            'guardian_ic' => 'nullable|string|max:20',
            'registration_type' => 'required|string|in:parents,guardian',
            'role' => 'required|string|max:255',
        ]);

        $validated['role'] = $validated['role'] ?? 'parents';
 
        // Find ParentRecord and related models
        $parentRecord = \App\Models\ParentRecord::with(['enrollment', 'father', 'mother', 'guardian', 'child'])->findOrFail($parentRecordId);

        $enrollment = $parentRecord->enrollment;
        $father = $parentRecord->father;
        $mother = $parentRecord->mother;
        $guardian = $parentRecord->guardian;
        $child = $parentRecord->child;

        // Update the enrollment status to "approved"
        if ($enrollment) {
            $enrollment->status = 'approved';
            $enrollment->save();
        }

        $emails = [];

        // Create User accounts and update parent tables with user_id
        if ($validated['registration_type'] === 'parents') {
            if (!empty($validated['father_email'])) {
                $fatherUser = User::where('email', $validated['father_email'])->first();
                if (!$fatherUser) {
                    $fatherUser = User::create([
                        'name' => $validated['father_name'],
                        'email' => $validated['father_email'],
                        'password' => Hash::make($validated['father_ic']),
                        'role' => $validated['role'],
                    ]);
                } else {
                    $fatherUser->password = Hash::make($validated['father_ic']);
                    $fatherUser->save();
                }
                // Update father table
                if ($father) {
                    $father->user_id = $fatherUser->id;
                    $father->save();
                }
                $emails[$validated['father_email']] = $validated['father_name'];
            }

            if (!empty($validated['mother_email'])) {
                $motherUser = User::firstOrCreate(
                    ['email' => $validated['mother_email']],
                    [
                        'name' => $validated['mother_name'],
                        'password' => Hash::make($validated['mother_ic']),
                        'role' => $validated['role'],
                    ]
                );
                if ($mother) {
                    $mother->user_id = $motherUser->id;
                    $mother->save();
                }
                $emails[$validated['mother_email']] = $validated['mother_name'];
            }
        } elseif ($validated['registration_type'] === 'guardian') {
            if (!empty($validated['guardian_email'])) {
                $guardianUser = User::firstOrCreate(
                    ['email' => $validated['guardian_email']],
                    [
                        'name' => $validated['guardian_name'],
                        'password' => Hash::make($validated['guardian_ic']),
                        'role' => $validated['role'],
                    ]
                );
                if ($guardian) {
                    $guardian->user_id = $guardianUser->id;
                    $guardian->save();
                }
                $emails[$validated['guardian_email']] = $validated['guardian_name'];
            }
        }

        // Send emails
        foreach ($emails as $email => $name) {
            try {
                Mail::html("
                    <h2>Dear $name,</h2>
                    <p>Your account has been approved. Below are your login credentials:</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Password:</strong> Your IC Number</p>
                    <p>Please log in and change your password immediately for security reasons.</p>
                    <p>Thank you.</p>
                ", function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Your Account Credentials');
                });

                Log::info("Email sent successfully to: $email");
            } catch (\Exception $e) {
                Log::error("Failed to send email to $email. Error: " . $e->getMessage());
            }
        }

        return redirect()->route('childrenRegisterRequest')->with('message', 'Parents registered successfully!');
    }



    //LOGIN HISTORY FOR ADMIN 
    protected function authenticated(Request $request, $user)
    {
        // Log the login details
        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'login_time' => now(),
        ]);
    }

    public function logout(Request $request)
    {
        // Update the logout time for the user's most recent login history
        LoginHistory::where('user_id', auth()->id())
            ->latest('login_time')
            ->first()
            ->update(['logout_time' => now()]);

        // Perform the logout
        auth()->logout();

        return redirect('/login');
    }

}
