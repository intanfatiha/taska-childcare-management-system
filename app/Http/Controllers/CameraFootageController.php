<?php

namespace App\Http\Controllers;

use App\Models\Camera_footage;
use Illuminate\Http\Request;

class CameraFootageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cameraFootages = Camera_footage::orderBy('created_at', 'desc')->get();
        return view('cameraFootages.index', compact('cameraFootages'));


    } 


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {

        try {
            // Ensure the user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            // Validate the request
            $request->validate([
                // 'footagedocument' => 'required|file|mimetypes:video/webm',
                'start_time' => 'required',
                'end_time' => 'required',
                'date' => 'required|date'
            ]);

            

            // Debugging: Log file details
            if ($request->hasFile('footagedocument')) {
                $file = $request->file('footagedocument');
                \Log::info('Uploaded file MIME type: ' . $file->getMimeType());
                \Log::info('Uploaded file extension: ' . $file->getClientOriginalExtension());
                \Log::info('Uploaded file size: ' . $file->getSize());
            }

            // Get the uploaded file
            $file = $request->file('footagedocument');
            $directory = public_path('uploads/cameraFootages');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Move the file to the directory
            $file->move($directory, $filename);

            // Save the footage details in the database
            $footage = Camera_footage::create([
                'user_id' => auth()->id(),
                'start_time' => date("H:i:s", strtotime($request->start_time)),
                'end_time' => date("H:i:s", strtotime($request->end_time)),
                'date' => $request->date,
                'file_location' => 'uploads/cameraFootages/' . $filename,
            ]);
\Log::info('DB Name: ' . \DB::connection()->getDatabaseName());

            return response()->json([
                'success' => true,
                'message' => 'Footage saved successfully!',
                'data' => $footage
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in CameraFootageController@store:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Camera_footage $camera_footage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camera_footage $camera_footage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Camera_footage $camera_footage)
    {
        //
    }

    /**
     * Remove the specified resource from storage. 
     */
    public function destroy(Camera_footage $camera_footage)
    {
         $footage = Camera_footage::findOrFail($camera_footage->id);

        // Delete the file from the server
        $filePath = public_path($footage->file_location);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record from the database
        $footage->delete();

        return redirect()->route('camera-footages.index')->with('success', 'Footage deleted successfully!');
    
    }
}
