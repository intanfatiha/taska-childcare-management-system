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
        //
        // $Camera_footages = Camera_footage::all();
        // return view('cameraFootages.index', compact('Camera_footages'));

        return view('cameraFootages.index'); 
      
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
        //
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
        //
    }
}
