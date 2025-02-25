<?php

namespace App\Http\Controllers;

use App\Models\RoomReservation;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomReservationController extends Controller
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
        $user = auth()->user(); //auth utk sesapa dh login , akn trik semua data user tu . function user tu akan tarik from table user
        $room = Room::findOrFail(request('room_id')); //findOrFail to == sql select all from rooms where id = room_id
        return view('roomreservations.create', compact('user','room')); //compact - pass kan variable from $user ke create.php . nama kena sama tanpa $
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant' => 'required| integer|min:1',
            'purpose' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::findOrFail($request->input('room_id')); //sql select all from room where id = ?

        if($request->input('participant') > $room->capacity){
            return redirect()->back()->withErrors([
                'participant' => 'The number of participants exceeds the room capacity of'. $room->capacity,
            ])->withInput();
        }

        //sql insert all from room where id = ?
        RoomReservation::create(array_merge($validatedData,[
            'room_id' => $request->input('room_id'),
            'user_id' =>$request->input('user_id')
        ]));

        return redirect()->back()->with('message','Reservation Successfully Sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomReservation $roomReservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomReservation $roomReservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomReservation $roomReservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomReservation $roomReservation)
    {
        //
    }
}
