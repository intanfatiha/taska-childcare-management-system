<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('registrations.registration');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $registration_type = $request->registration_type;

        if($registration_type == "parents"){

            $validated = $request->validate([

                'child_name' => 'required|string|max:255',
                'child_birth_date' => 'required|date',
                'child_gender' => 'required|in:Male,Female',
                'child_age' => 'required|string|max:255',
                'child_position' => 'nullable|integer',
                'child_siblings_count' => 'nullable|integer',
                'child_address' => 'required|string',
                'child_allergies' => 'nullable|string',
                'child_medical_conditions' => 'nullable|string',
                'child_previous_childcare' => 'nullable|string',
                'child_photo' => 'required|image|max:2048',
                'birth_cert' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'immunization_record' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'registration_type' => 'required|in:parents,guardian',
                //father info
                'father_name' => 'required|string|max:255',
                'father_email' => 'required|email|unique:fathers,father_email',
                'father_phoneno' => 'required|string|max:15',
                'father_ic' => 'required|string|unique:fathers,father_ic',
                'father_address' => 'required|string',
                'father_nationality' => 'required|string',
                'father_race' => 'required|string',
                'father_religion' => 'required|string',
                'father_occupation' => 'required|string',
                'father_income' => 'required|numeric',
                'father_staff_number' => 'nullable|string',
                'father_ptj' => 'nullable|string',
                'father_office_number' => 'nullable|string',
                //mother info
                'mother_name' => 'required|string|max:255',
                'mother_email' => 'required|email|unique:mothers,mother_email',
                'mother_phoneno' => 'required|string',
                'mother_ic' => 'required|string|unique:mothers,mother_ic',
                'mother_address' => 'required|string',
                'mother_nationality' => 'required|string',
                'mother_race' => 'required|string',
                'mother_religion' => 'required|string',
                'mother_occupation' => 'required|string',
                'mother_income' => 'required|string',
                'mother_staff_number' => 'nullable|string',
                'mother_ptj' => 'nullable|string',
                'mother_office_number' => 'nullable|string',
            ]);



        }else{


            $validated = $request->validate([

                'child_name' => 'required|string|max:255',
                'child_birth_date' => 'required|date',
                'child_gender' => 'required|in:Male,Female',
                'child_age' => 'required|string|max:255',
                'child_position' => 'nullable|integer',
                'child_siblings_count' => 'nullable|integer',
                'child_address' => 'required|string',
                'child_allergies' => 'nullable|string',
                'child_medical_conditions' => 'nullable|string',
                'child_previous_childcare' => 'nullable|string',
                'child_photo' => 'required|image|max:2048',
                'birth_cert' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'immunization_record' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'registration_type' => 'required|in:parents,guardian',
                //guardian info
                'guardian_name' => 'required|string|max:255',
                'guardian_relation' => 'required|string',
                'guardian_email' => 'required|email|unique:guardians,guardian_email',
                // 'guardian_email' => 'required|email',
                'guardian_phoneNo' => 'required|string|max:15',
                'guardian_ic' => 'required|string|unique:guardians,guardian_ic',
                // 'guardian_ic' => 'required|string',
                'guardian_address' => 'required|string',
                'guardian_nationality' => 'required|string',
                'guardian_race' => 'required|string',
                'guardian_religion' => 'required|string',
                'guardian_occupation' => 'required|string',
                'guardian_monthly_income' => 'required|string',
                'guardian_staff_number' => 'nullable|string',
                'guardian_ptj' => 'nullable|string',
                'guardian_office_number' => 'nullable|string',
            ]);
        }

        // Convert father_income to float before storing
        $validatedData['father_income'] = (float) $request->father_income;

        DB::beginTransaction(); //to ensure all data is saved or none

        try{

            // dd('Made it to this point');
               // 1. First create the registration record
                $registration = Enrollment::create([
                    'status' => 'pending',
                    'registration_type' => $request->registration_type,
                ]);

                $fatherId = null;
                $motherId = null;
                $guardianId = null;


            //Check if there is an existing father id
            if ($request->registration_type == 'parents')
            {
                 // Search father in the database
                $father = Father::where('father_ic', $request->father_ic)->first();

                if (!$father)
                {
                    //create a new father record
                    $father = Father::create([
                        'enrollment_id' => $registration->id,
                        'father_name' => $request->father_name,
                        'father_email' => $request->father_email,
                        'father_phoneNo' => $request->father_phoneno,
                        'father_ic' => $request->father_ic,
                        'father_address' => $request->father_address,
                        'father_nationality' => $request->father_nationality,
                        'father_race' => $request->father_race,
                        'father_religion' => $request->father_religion,
                        'father_occupation' => $request->father_occupation,
                        'father_monthly_income' => $request->father_income,
                        'father_staff_number' => $request->father_staff_number,
                        'father_ptj' => $request->father_ptj,
                        'father_office_number' => $request->father_office_number,
                        'user_id' => null,
                    ]);
                }

                    $fatherId = $father->id;



                // Search mother in the database
                $mother = Mother::where('mother_ic', $request->mother_ic)->first();

                if (!$mother)
                {
                      // Create a new mother record
                      $mother = Mother::create([
                        'enrollment_id' => $registration->id,
                        'mother_name' => $request->mother_name,
                        'mother_email' => $request->mother_email,
                        'mother_phoneNo' => $request->mother_phoneno,
                        'mother_ic' => $request->mother_ic,
                        'mother_address' => $request->mother_address,
                        'mother_nationality' => $request->mother_nationality,
                        'mother_race' => $request->mother_race,
                        'mother_religion' => $request->mother_religion,
                        'mother_occupation' => $request->mother_occupation,
                        'mother_monthly_income' => $request->mother_income,
                        'mother_staff_number' => $request->mother_staff_number,
                        'mother_ptj' => $request->mother_ptj,
                        'mother_office_number' => $request->mother_office_number,
                        'user_id' => null,
                    ]);

                }
                    $motherId = $mother->id;

            } else {
                if($request->registration_type == 'guardian')
                {
                    $guardian = Guardian::where('guardian_ic', $request->guardian_ic)->first();

                    if(!$guardian)
                    {
                        $guardian = Guardian::create([
                            'enrollment_id' => $registration->id,
                            'guardian_name' => $request->guardian_name,
                            'guardian_relation' => $request->guardian_relation,
                            'guardian_email' => $request->guardian_email,
                            'guardian_phoneNo' => $request->guardian_phoneNo,
                            'guardian_ic' => $request->guardian_ic,
                            'guardian_address' => $request->guardian_address,
                            'guardian_nationality' => $request->guardian_nationality,
                            'guardian_race' => $request->guardian_race,
                            'guardian_religion' => $request->guardian_religion,
                            'guardian_occupation' => $request->guardian_occupation,
                            'guardian_monthly_income' => $request->guardian_monthly_income,
                            'guardian_staff_number' => $request->guardian_staff_number,
                            'guardian_ptj' => $request->guardian_ptj,
                            'guardian_office_number' => $request->guardian_office_number,
                            'user_id' => null,
                        ]);

                    }

                    $guardianId = $guardian->id;
                }

            }

              //Handle file uploads
              $childPhotoPath = $request->file('child_photo')->store('children_photos','public');
              $birthCertPath = $request->file('birth_cert')->store('documents','public');
              $immunizationPath = $request->file('immunization_record')->store('documents','public');

              //Create children record
              $children = Child::create([
                  'enrollment_id' => $registration->id,
                  'child_name'=> $request->child_name,
                  'child_birthdate'=> $request->child_birth_date,
                  'child_gender'=> $request->child_gender,
                  'child_age'=> $request->child_age,
                  'child_address'=> $request->child_address,
                  'child_sibling_number'=> $request->child_siblings_count,
                  'child_numberInSibling' => $request->child_position,
                  'child_allergies'=> $request->child_allergies,
                  'child_medical_conditions' => $request->child_medical_conditions,
                  'child_previous_childcare'=> $request->child_previous_childcare,
                  'child_birth_cert'=> $birthCertPath,
                  'child_immunization_record' => $immunizationPath,
                  'child_photo'=> $childPhotoPath
              ]);

              DB::commit();

              //Send email notification to admin when new request is made
              try {
                  $loginUrl = route('login');
                    Mail::html("
                        <div style='font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;'>
                            <div style='max-width: 520px; margin: auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;'>
                                <h2 style='color: #2563eb; margin-bottom: 16px;'>📝 New Registration Request</h2>
                                <p style='color: #374151; font-size: 16px; margin-bottom: 16px;'>
                                    A new childcare registration request has been submitted.
                                </p>
                                
                                <p style='color: #374151; margin-bottom: 24px;'>
                                    Please log in to the admin panel to review and process this request.
                                </p>
                                <div style='text-align: center; margin-bottom: 24px;'>
                                    <a href='{$loginUrl}' style='display: inline-block; background: #2563eb; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px;'>
                                        🔑 Login to Admin Panel
                                    </a>
                                </div>
                                <p style='color: #9ca3af; font-size: 13px; margin-top: 32px;'>
                                    This is an automated notification from Taska Childcare Management System.
                                </p>
                            </div>
                        </div>
                    ", function ($message) {
                        $message->to('kimminseok512@gmail.com')
                            ->subject('New Childcare Registration Request');
                    });

                    Log::info("Request Submitted!");
                } catch (\Exception $e) {
                    Log::error("Failed to send admin notification email. Error: " . $e->getMessage());
                }


              return redirect()->route('enrollments.confirmation')->with('success', 'Registration submitted successfully.');
            } catch (\Exception $e) {
              DB::rollBack();
              dd( $e->getMessage());
              return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());

            }

    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
