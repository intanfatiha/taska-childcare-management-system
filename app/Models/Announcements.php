<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementsFactory> */
    use HasFactory;
    protected $table = 'announcements';

    protected $fillable = [
        'announcement_location',
        'announcement_date',
        'announcement_time',
        'activity_description',
        'announcement_type'
    ];
}
