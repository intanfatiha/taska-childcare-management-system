<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;





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
        $enrollment = $adminActivity->load(['father', 'mother', 'guardian', 'child']);
        
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
        //
    }

    

    public function childrenRegisterRequest()
    {
        $enrollments = Enrollment::with(['father','mother','guardian','child'])->paginate(10);
        return view('adminActivity.childRegisterRequest', compact('enrollments'));
        //return 'Test: Route and Controller are working.';

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

    //To register parents/guardian account
    public function approveRegistration(Request $request, $enrollmentId)
{
    // Validate inputs
    $validated = $request->validate([
        'father_email' => 'nullable|email|unique:users,email',
        'mother_email' => 'nullable|email|unique:users,email',
        'guardian_email' => 'nullable|email|unique:users,email',
        'father_name' => 'nullable|string|max:255',
        'mother_name' => 'nullable|string|max:255',
        'guardian_name' => 'nullable|string|max:255',
        'registration_type' => 'required|string|in:parents,guardian',
        'password' => 'required|min:6|confirmed',
    ]);

    $enrollment = Enrollment::findOrFail($enrollmentId);

    $users = [];
    $emails = []; 

    if ($validated['registration_type'] === 'parents') {
        if (!empty($validated['father_email'])) {
            $users[] = User::create([
                'name' => $validated['father_name'],
                'email' => $validated['father_email'],
                'password' => Hash::make($validated['password']),
                'role' => 'parents',
            ]);
            $emails[$validated['father_email']] = $validated['father_name']; // Add to email list
        }

        if (!empty($validated['mother_email'])) {
            $users[] = User::create([
                'name' => $validated['mother_name'],
                'email' => $validated['mother_email'],
                'password' => Hash::make($validated['password']),
                'role' => 'parents',
            ]);
            $emails[$validated['mother_email']] = $validated['mother_name']; // Add to email list
        }
    } elseif ($validated['registration_type'] === 'guardian') {
        if (!empty($validated['guardian_email'])) {
            $users[] = User::create([
                'name' => $validated['guardian_name'],
                'email' => $validated['guardian_email'], // Fixed typo here
                'password' => Hash::make($validated['password']),
                'role' => 'parents',
            ]);
            $emails[$validated['guardian_email']] = $validated['guardian_name']; // Add to email list
        }
    }

    // Send emails
    foreach ($emails as $email => $name) {
        try {
            Mail::html("
                <h2>Dear $name,</h2>
                <p>Your account has been approved. Below are your login credentials:</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Password:</strong> {$validated['password']}</p>
                <p>Please log in and change your password immediately for security reasons.</p>
                <p>Thank you.</p>
            ", function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your Account Credentials');
            });
            
            // Log successful email
            Log::info("Email sent successfully to: $email");
        } catch (\Exception $e) {
            // Log email sending failures
            Log::error("Failed to send email to $email. Error: " . $e->getMessage());
        }
    }

    return redirect()->route('childrenRegisterRequest')->with('message', 'Parents registered successfully!');
}
}
