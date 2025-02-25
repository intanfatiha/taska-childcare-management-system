<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $announcements = Announcements::all();
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate
       ([
            'announcement_location'=>'nullable|string|max:50',
            'announcement_date'=>'required|date',
            'announcement_time'=>'required|date_format:H:i',
            'activity_description'=>'required|string|max:255',
            'announcement_type'=>'required|string|max:50',
        ]);

        // Announcement::create($request->all());
        Announcements::create( $validatedData);
        //return redirect()->route('announcements.create')->with('message', 'Announcement created successfully!');
        return redirect()->route('announcements.index')->with('message', 'Announcement created successfully!');


        //return redirect()->back()->with('message', 'Announcement created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Announcements $announcements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcements = Announcements::findOrFail($id);
        return view('announcements.edit',compact('announcements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcements $announcement)
    {
        // Validate the incoming request data

        $request->validate([
            'announcement_location' => 'nullable|string|max:255',
            'announcement_date' => 'required|date',
            'announcement_time' => 'required|date_format:H:i',
            'activity_description' => 'required|string',
            'announcement_type' => 'required|string|max:255',
        ]);

        // Update the announcement with validated data
        $announcement->update($request->all());

        // Redirect back with a success message
        return redirect()->route('announcements.index')->with('message', 'Announcement updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Use the Query Builder to delete the announcement by its ID
        Announcements::where('id', $id)->delete();

        // Redirect with success message
        return redirect()->route('announcements.index')->with('message', 'Announcement deleted successfully');
    }
}
