<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    /** @use HasFactory<\Database\Factories\RoomReservationFactory> */
    use HasFactory;
    protected $fillable=[
        'room_id',
        'user_id',
        'start_date',
        'end_date',
        'participant',
        'purpose',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function room(){
        return $this->belongsTo(Room::class,'room_id');
    }
}
