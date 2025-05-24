<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'children_id',
        'attendance_date',
        'time_in',
        'time_out',
        'attendance_status',
        'attendance_overtime',
    ];
    
      // Relationship with Child model
      public function child()
      {
          return $this->belongsTo(Child::class, 'children_id');
      }
  
      
}
