<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\ParentInfo;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('parentInfos.childrenForm');
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
        $validatedData = $request->validate
        (
        [ 
            'child_name' => 'required|string|max:255',
            'child_birthdate' => 'required|date',
            'child_gender' => 'required|in:Male,Female',
            'child_age' => 'required|integer|min:0',
            'child_address' => 'required|string',            
            'child_sibling_number' => 'required|integer|min:0',
            'child_numberInSibling' => 'required|integer|min:1',
            'child_allergies' => 'nullable|string',
            'child_medical_conditions' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'child_previous_childcare' => 'nullable|string',
            'child_birth_certificate' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'child_immunization_record' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'child_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'registration_status' => 'required|in:Pending,Completed,Rejected',
        ],
        );

        // Check if a photo was uploaded
        if ($request->hasFile('child_photo')) {
            $image = $request->file('child_photo');
            $image_name = 'child_' . time() . '.' . $image->getClientOriginalExtension(); //utk rename gmbr tu. kebetulan nama sama boleh jadi error.thats why ada msa

            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/children');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Resize the image to 300x300 using GD
            $resized_image = imagecreatetruecolor(300, 300); //utk muat dekat srver. 300,300
            $source_image = ($image->getClientOriginalExtension() == 'png') ? imagecreatefrompng($image->getRealPath()) : imagecreatefromjpeg($image->getRealPath());
            list($width, $height) = getimagesize($image->getRealPath());
            imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 300, 300, $width, $height);

            // Save the image
            if ($image->getClientOriginalExtension() == 'png') {
                imagepng($resized_image, $directory . '/' . $image_name);
            } else {
                imagejpeg($resized_image, $directory . '/' . $image_name, 80); // 80 for JPEG quality
            }

            // Clean up resources
            imagedestroy($resized_image);
            imagedestroy($source_image);

            // Store the image path in the validated data
            $validatedData['child_photo'] = $image_name;
        }

        $validatedData['parent_id'] = $request->input('parent_id'); // Ensure parent_id is captured
        Children::create($validatedData); // ORM = equivelent to insert into (SQL). Room to nama model and then function create 

        //back() - back to page yang sama
        return redirect()->back()->with('message', 'Children registration created successfully! Wait 3-4 days for request approval');
    }

    /**
     * Display the specified resource.
     */
    public function show(Children $children)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Children $children)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Children $children)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Children $children)
    {
        //
    }
}
