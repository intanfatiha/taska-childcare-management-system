<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use Illuminate\Http\Request;

class ParentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
    }

    public function showRegistrationForm()
    {
        //
        return view('parentChildrenRegister');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    //for parent or guardian type selection
    public function processRelationType(Request $request)
    {
        // Validate the selection
        $validatedData = $request->validate([
            'relation' => 'required|in:parents,guardian',
        ]);

        // Create a parent info record
        // $parentInfo = ParentInfo::create();

        // Store parent info ID in session for later use
        // $parentInfo = ParentInfo::create([
        //     'user_id' => auth()->user()->id, // Associate the authenticated user
        // ]);
        
        //  // Store parent info ID in session for later use
        // session(['parent_info_id' => $parentInfo->id]);

        // Redirect to the respective form based on the relation type
        if ($request->relation === 'parents') {
            return redirect()->route('father.form');
        } else {
            return redirect()->route('guardian.form');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         
    }

    //show father form
    public function showFatherForm()
    {
        return view('parentInfos.fatherForm');
    }

    //store father data into database
    public function storeFather(Request $request)
    {
    $validatedData = $request->validate([
        'father_name' => 'required|string|max:255',
        'father_email' => 'required|email|unique:fathers,email',
        'father_phoneNo' => 'required|string',
        'father_ic' => 'required|string|unique:fathers,ic_number',
        'father_address' => 'required|string',
        'father_nationality' => 'required|string',
        'father_race' => 'required|string',
        'father_religion' => 'required|string',
        'father_occupation' => 'required|string',
        'father_monthly_income' => 'required|string',
        'father_staff_number' => 'nullable|string',
        'father_ptj' => 'nullable|string',
        'father_office_number' => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Create the User record for login
            $user = User::create([
                'name' => $validatedData['father_name'],
                'email' => $validatedData['father_email'],
                'password' => Hash::make('password123'), // Replace with secure password if needed
                'role' => 'parent',
            ]);

            // Create the ParentInfo record linked to the User
            $parentInfo = ParentInfo::create([
                'user_id' => $user->id,
            ]);

            // Create the Father record
            Father::create([
                'parent_info_id' => $parentInfo->id,
                'father_name' => $validatedData['father_name'],
                'father_email' => $validatedData['father_email'],
                'father_phoneNo' => $validatedData['father_phoneNo'],
                'father_ic' => $validatedData['father_ic'],
                'father_address' => $validatedData['father_address'],
                'father_nationality' => $validatedData['father_nationality'],
                'father_race' => $validatedData['father_race'],
                'father_religion' => $validatedData['father_religion'],
                'father_occupation' => $validatedData['father_occupation'],
                'father_monthly_income' => $validatedData['father_monthly_income'],
                'father_staff_number' => $validatedData['father_staff_number'] ?? null,
                'father_ptj' => $validatedData['father_ptj'] ?? null,
                'father_office_number' => $validatedData['father_office_number'] ?? null,
            ]);
        });

        return redirect()->route('parentInfos.motherForm')->with('message', 'Father registered successfully.');;
        }  catch (\Exception $e) {
            return back()->with('error', 'Error registering father: ' . $e->getMessage())->withInput();
        }
    }

    // display mother form
    public function showMotherForm()
    {
        return view('parentInfos.motherForm');
    }

    //store mother data into database
    public function storeMother(Request $request)
{
    $validatedData = $request->validate([
        'mother_name' => 'required|string|max:255',
        'mother_email' => 'required|email|unique:users,email',
        'mother_phoneNo' => 'required|string',
        'mother_ic' => 'required|string|unique:mothers,ic_number',
        'mother_address' => 'required|string',
        'mother_nationality' => 'required|string',
        'mother_race' => 'required|string',
        'mother_religion' => 'required|string',
        'mother_occupation' => 'required|string',
        'mother_monthly_income' => 'required|string',
        'mother_staff_number' => 'nullable|string',
        'mother_ptj' => 'nullable|string',
        'mother_office_number' => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Create the User record for login
            $user = User::create([
                'name' => $validatedData['mother_name'],
                'email' => $validatedData['mother_email'],
                'password' => Hash::make('password123'), // Replace with secure password
                'role' => 'parent',
            ]);

            // Retrieve the existing ParentInfo from session
            $parentInfoId = session('parent_info_id');
            $parentInfo = ParentInfo::find($parentInfoId);

            if (!$parentInfo) {
                throw new \Exception('ParentInfo not found in session');
            }

            // Create the Mother record
            Mother::create([
                'parent_info_id' => $parentInfo->id,
                'mother_name' => $validatedData['mother_name'],
                'mother_email' => $validatedData['mother_email'],
                'mother_phoneNo' => $validatedData['mother_phoneNo'],
                'mother_ic' => $validatedData['mother_ic'],
                'mother_address' => $validatedData['mother_address'],
                'mother_nationality' => $validatedData['mother_nationality'],
                'mother_race' => $validatedData['mother_race'],
                'mother_religion' => $validatedData['mother_religion'],
                'mother_occupation' => $validatedData['mother_occupation'],
                'mother_monthly_income' => $validatedData['mother_monthly_income'],
                'mother_staff_number' => $validatedData['mother_staff_number'] ?? null,
                'mother_ptj' => $validatedData['mother_ptj'] ?? null,
                'mother_office_number' => $validatedData['mother_office_number'] ?? null,
            ]);
        });

        return redirect()->route('parentInfos.childrenForm');
    }  catch (\Exception $e) {
        return back()->with('error', 'Error registering mother: ' . $e->getMessage())->withInput();
    }
    }

    // Display guardian form 
    public function showGuardianForm()
    {
        return view('parentInfos.guardianForm');
    }

    //store guardian data into database
    public function storeGuardian(Request $request)
    {
    $validatedData = $request->validate([
        'guardian_name' => 'required|string|max:255',
        'guardian_email' => 'required|email|unique:users,email',
        'guardian_phoneNo' => 'required|string',
        'guardian_ic' => 'required|string|unique:guardians,guardian_ic',
        'guardian_address' => 'required|string',
        'guardian_nationality' => 'required|string',
        'guardian_race' => 'required|string',
        'guardian_religion' => 'required|string',
        'guardian_occupation' => 'required|string',
        'guardian_monthly_income' => 'required|string',
        'guardian_staff_number' => 'nullable|string',
        'guardian_ptj' => 'nullable|string',
        'guardian_office_number' => 'nullable|string',
        'guardian_relation' => 'required|string',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Create the User record for login
            $user = User::create([
                'name' => $validatedData['guardian_name'],
                'email' => $validatedData['guardian_email'],
                'password' => Hash::make('password123'), // Replace with secure password
                'role' => 'parent',
            ]);

            // // Retrieve the existing ParentInfo from session
            // $parentInfoId = session('parent_info_id');
            // $parentInfo = ParentInfo::find($parentInfoId);

            // if (!$parentInfo) {
            //     throw new \Exception('ParentInfo not found in session');
            // }

              // Create the ParentInfo record linked to the User (for the guardian)
              $parentInfo = ParentInfo::create([
                'user_id' => $user->id,
            ]);

            // Create the Guardian record
            Guardian::create([
                'parent_info_id' => $parentInfo->id,
                'guardian_name' => $validatedData['guardian_name'],
                'guardian_email' => $validatedData['guardian_email'],
                'guardian_phoneNo' => $validatedData['guardian_phoneNo'],
                'guardian_ic' => $validatedData['guardian_ic'],
                'guardian_address' => $validatedData['guardian_address'],
                'guardian_nationality' => $validatedData['guardian_nationality'],
                'guardian_race' => $validatedData['guardian_race'],
                'guardian_religion' => $validatedData['guardian_religion'],
                'guardian_occupation' => $validatedData['guardian_occupation'],
                'guardian_monthly_income' => $validatedData['guardian_monthly_income'],
                'guardian_staff_number' => $validatedData['guardian_staff_number'] ?? null,
                'guardian_ptj' => $validatedData['guardian_ptj'] ?? null,
                'guardian_office_number' => $validatedData['guardian_office_number'] ?? null,
                'guardian_relation' => $validatedData['guardian_relation'],
            ]);
        });

        return redirect()->route('children.form')->with('success', 'guardian registered successfully');
    } catch (\Exception $e) {
        return back()->with('error', 'Error registering guardian: ' . $e->getMessage())->withInput();
    }
    }



    /**
     * Display the specified resource.
     */
    public function show(ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentInfo $parentInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentInfo $parentInfo)
    {
        //
    }
}
