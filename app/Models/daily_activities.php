<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily_activities extends Model
{
    /** @use HasFactory<\Database\Factories\DailyActivitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_title',
        'activity_photo',
        'post_date',
        'post_time',
        'post_desc',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
