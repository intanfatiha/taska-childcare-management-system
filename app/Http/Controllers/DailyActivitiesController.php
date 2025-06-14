<?php

namespace App\Http\Controllers;

use App\Models\daily_activities;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
       // $daily_activities = daily_activities::all();
    //    $daily_activities = daily_activities::orderBy('created_at', 'desc')->get();
    //    return view('daily_activities.index', compact('daily_activities'));  
    
        $filter = $request->get('filter_type', 'all'); // Default to 'all'

        // Initialize date range variables
        $startDate = null;
        $endDate = null;
        if ($filter === 'date') {
            $startDate = Carbon::parse($request->get('date'))->startOfDay();
            $endDate = Carbon::parse($request->get('date'))->endOfDay();
        } elseif ($filter === 'month') {
            $startDate = Carbon::parse($request->get('month'))->startOfMonth();
            $endDate = Carbon::parse($request->get('month'))->endOfMonth();
        } elseif ($filter === 'year') {
            $startDate = Carbon::createFromDate($request->get('year'))->startOfYear();
            $endDate = Carbon::createFromDate($request->get('year'))->endOfYear();
        }
        // Fetch activities based on the filter
        $query = daily_activities::query();

        if ($startDate && $endDate) {
            $query->whereBetween('post_date', [$startDate, $endDate]);
        }
    

        $daily_activities = $query->orderBy('created_at', 'desc')->paginate(10); // Adjust the number of items per page as needed

        return view('daily_activities.index', compact('daily_activities','filter'));


    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('daily_activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate
        (
        [ 
            'post_title' => 'required|string|max:255',
            'activity_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048', 
            'post_date' => 'required|date|after_or_equal:today',
            'post_time' => 'required|date_format:H:i',
            'post_desc' => 'required|string|max:255'
        ],
        );

        // Add the authenticated user's ID to the validated data
        $validatedData['user_id'] = auth()->id();

         // Check if a photo was uploaded
         if ($request->hasFile('activity_photo')) {
            $image = $request->file('activity_photo');
            $image_name = 'activityBoard_' . time() . '.' . $image->getClientOriginalExtension(); 

            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/dailyActivityBoards');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $resized_image = imagecreatetruecolor(500, 500); 
            $source_image = ($image->getClientOriginalExtension() == 'png') ? imagecreatefrompng($image->getRealPath()) : imagecreatefromjpeg($image->getRealPath());
            list($width, $height) = getimagesize($image->getRealPath());
            imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 500, 500, $width, $height);

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
            $validatedData['activity_photo'] = $image_name;
        }

        daily_activities::create($validatedData); // ORM = equivelent to insert into (SQL). 

        //back() - back to page yang sama
        return redirect()->route('daily_activities.index')->with('message', 'Post created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(daily_activities $daily_activities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(daily_activities $daily_activity)
    {
        //
        return view('daily_activities.edit',compact('daily_activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, daily_activities $daily_activity)
    {
        $validatedData = $request->validate(
            [ 
                'post_title' => 'required|string|max:255',
                'activity_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', 
                'post_date' => 'required|date',
                'post_time' => 'required|date_format:H:i',
                'post_desc' => 'required|string|max:255'
            ]);
        
            // Add the authenticated user's ID to the validated data
            $validatedData['user_id'] = auth()->id();
        
            // Check if a new photo was uploaded
            if ($request->hasFile('activity_photo')) {
                $image = $request->file('activity_photo');
                $image_name = 'activityBoard_' . time() . '.' . $image->getClientOriginalExtension();
        
                // Set directory path and create directory if it doesn't exist
                $directory = public_path('uploads/dailyActivityBoards');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
        
                // Resize the image to 500x500
                $resized_image = imagecreatetruecolor(500, 500);
                $source_image = ($image->getClientOriginalExtension() == 'png') 
                                ? imagecreatefrompng($image->getRealPath()) 
                                : imagecreatefromjpeg($image->getRealPath());
                list($width, $height) = getimagesize($image->getRealPath());
                imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 500, 500, $width, $height);
        
                // Save the resized image
                if ($image->getClientOriginalExtension() == 'png') {
                    imagepng($resized_image, $directory . '/' . $image_name);
                } else {
                    imagejpeg($resized_image, $directory . '/' . $image_name, 80);
                }
        
                // Clean up resources
                imagedestroy($resized_image);
                imagedestroy($source_image);
        
                // Store the new image path
                $validatedData['activity_photo'] = $image_name;
        
                // Delete the old photo if it exists
                if ($daily_activity->activity_photo && file_exists($directory . '/' . $daily_activity->activity_photo)) {
                    unlink($directory . '/' . $daily_activity->activity_photo);
                }
            } 
        
            // Update the activity using the instance method
            $daily_activity->update($validatedData);
        
    return redirect()->route('daily_activities.index')->with('message', 'Post updated successfully');

            //return redirect()->route('daily_activities.index')->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(daily_activities $daily_activity)
    {
   
        try {
            // Delete the associated image file if it exists
            if ($daily_activity->activity_photo) {
                $image_path = public_path('uploads/dailyActivityBoards/' . $daily_activity->activity_photo);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Delete the record
            $daily_activity->delete();

            return redirect()->route('daily_activities.index')->with('message', 'Post deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete post. ' . $e->getMessage());
        }
    
    }


}