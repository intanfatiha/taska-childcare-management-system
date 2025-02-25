<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    //security dlm laravel. define apa data yg allow masuk dlm field table rooms
    protected $fillable = [
        'name',
        'photo',
        'capacity',
    ];

    public function reserves()
    {
        return $this->hasMany(RoomReservation::Class,'room_id');
    }
}
