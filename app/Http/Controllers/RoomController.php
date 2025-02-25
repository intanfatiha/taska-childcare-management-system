<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = Room::paginate(10); //eloquent ORM == menggantikan SQL select * statememt
        return view('rooms.index', compact('rooms')); // compact = satu variable declaration utk hntr dekat rooms.index
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate
        (
        [ //array

            'name' => 'required|string|max:225|unique:rooms,name', //rooms adalah nama yang uniq
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'capacity' => 'required|integer|between:40,150',
        ],

        //kalau nak dalam Bahasa Melayu (KENA CUSTOM)
        //[
            
           // 'name.required' => 'Sila isi nama bilik',
           // 'capacity.between' => 'Kapasiti mestilah di antara 40 hingga 150',

        //]
        );

        // Check if a photo was uploaded
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = 'room_' . time() . '.' . $image->getClientOriginalExtension(); //utk rename gmbr tu. kebetulan nama sama boleh jadi error.thats why ada msa

            //dd() function for debugging.ni kalau nnk check path n details
            // dd([

            //     'image' => $image,
            //     'image_name' => $image_name

            // ]);

            //dd($image);


            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/rooms');
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
            $validatedData['photo'] = $image_name;
        }

        Room::create($validatedData); // ORM = equivelent to insert into (SQL). Room to nama model and then function create 

        //back() - back to page yang sama
        return redirect()->back()->with('message', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //list
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
        return view('rooms.edit',compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
        $validatedData = $request->validate( [ //array

            'name' => 'required|string|max:225|unique:rooms,name,'.$room->id, //rooms adalah nama yang uniq
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'capacity' => 'required|integer|between:40,150',
        ]);

        if ($request->hasFile('photo'))
        {
            $image = $request->file('photo');
            $image_name = 'room_' . time() . '.' . $image->getClientOriginalExtension(); //utk rename gmbr tu. kebetulan nama sama boleh jadi error.thats why ada msa

            //dd() function for debugging.ni kalau nnk check path n details
            // dd([

            //     'image' => $image,
            //     'image_name' => $image_name

            // ]);

            //dd($image);


            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/rooms');
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
            $validatedData['photo'] = $image_name;
        }
        else{
            $validatedData['photo'] = $room->photo;
        }

        $room->update($validatedData); //equivalent to sql update nama_table set

        return redirect()->back()->with('message','Room updated successfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
        $room->delete(); //equivalent to delete from table_name where id="";

        // return redirect()->route('rooms.index')->with('message','Room deleted successfully');
        return redirect()->back()->with('message','Room deleted successfully');
    }
}