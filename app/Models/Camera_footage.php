<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera_footage extends Model
{
    /** @use HasFactory<\Database\Factories\CameraFootageFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'date',
        'file_location',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
