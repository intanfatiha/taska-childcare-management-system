<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\User;
use App\Models\ParentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $eventType = $request->get('event_type', 'all');

        // Query announcements based on the selected event type
        $query = Announcements::query();
    
        if ($eventType !== 'all') {
            $query->where('announcement_type', $eventType);
        }
    
        $announcements = $query->orderBy('announcement_date', 'desc')->get();
    
        return view('announcements.index', compact('announcements', 'eventType'));
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
            'announcement_title'=>'required|string|max:255',
            'announcement_location'=>'nullable|string|max:50',
            'announcement_date'=>'required|date',
            'announcement_time'=>'required|date_format:H:i',
            'activity_description'=>'required|string|max:255',
            'announcement_type'=>'required|string|max:50',
        ]);

        // Create the announcement
    $announcement = Announcements::create($validatedData);

    // Send email to all users with the 'parents' role
    $parents = User::where('role', 'parents')->get();
    foreach ($parents as $parent) {
        try {
            $htmlContent = "
                <h2>Dear {$parent->name},</h2>
                <p>We hope this message finds you well.</p>
                <p>Please be informed that a new announcement has been posted with the following details:</p>
                <p><strong>Title:</strong> {$announcement->announcement_title}</p>
                <p><strong>Category:</strong> {$announcement->announcement_type}</p>
                <p><strong>Date:</strong> {$announcement->announcement_date}</p>
                <p><strong>Time:</strong> {$announcement->announcement_time}</p>
                <p><strong>Location:</strong> {$announcement->announcement_location}</p>
                <p><strong>Description:</strong> {$announcement->activity_description}</p>
                <p>Thank you for your attention and continued support.</p>
                <p>Warm regards,<br>
                Taska Hikmah</p>
                <hr>
                <p style=\"font-size: 0.9em; color: #555;\">
                <p>This is an automated message. Please do not reply to this email.</p>
                For any inquiries, please contact us or call us at 07-1234567.<br>
                </p>
            ";

            Mail::send([], [], function ($message) use ($parent, $htmlContent) {
                $message->to($parent->email)
                        ->subject('New Announcement From Taska Hikmah')
                        ->html($htmlContent); // Use the html() method
            });

            Log::info("Announcement email sent successfully to: {$parent->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send announcement email to {$parent->email}. Error: " . $e->getMessage());
        }
    }

        return redirect()->route('announcements.index')->with('message', 'Announcement created successfully!');


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

        $validatedData = $request->validate([
            'announcement_title' => 'required|string|max:255',
            'announcement_location' => 'nullable|string|max:255',
            'announcement_date' => 'required|date',
            'announcement_time' => 'required|date_format:H:i',
            'activity_description' => 'required|string',
            'announcement_type' => 'required|string|max:255',
        ]);

             // Update the announcement
    $announcement->update($validatedData);

    // Send email to all users with the 'parents' role
    $parents = User::where('role', 'parents')->get();
    foreach ($parents as $parent) {
        try {
            $htmlContent = "
                <h2>Dear {$parent->name},</h2>
                <p>We hope this message finds you well.</p>
                <p>Please be informed that an announcement has been updated with the following details:</p>
                <p><strong>Title:</strong> {$announcement->announcement_title}</p>
                <p><strong>Category:</strong> {$announcement->announcement_type}</p>
                <p><strong>Date:</strong> {$announcement->announcement_date}</p>
                <p><strong>Time:</strong> {$announcement->announcement_time}</p>
                <p><strong>Location:</strong> {$announcement->announcement_location}</p>
                <p><strong>Description:</strong> {$announcement->activity_description}</p>
                <p>Thank you for your attention and continued support.</p>
                <p>Warm regards,<br>
                Taska Hikmah</p>
                <hr>
                <p style=\"font-size: 0.9em; color: #555;\">
                <p>This is an automated message. Please do not reply to this email.</p>
                For any inquiries, please contact us or call us at 07-1234567.<br>
                </p>
            ";

            Mail::send([], [], function ($message) use ($parent, $htmlContent) {
                $message->to($parent->email)
                        ->subject('Updated Announcement From Taska Hikmah')
                        ->html($htmlContent); // Use the html() method
            });

            Log::info("Announcement update email sent successfully to: {$parent->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send announcement update email to {$parent->email}. Error: " . $e->getMessage());
        }
    }

            
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
