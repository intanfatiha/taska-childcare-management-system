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
        'parent_infos_id',
        'attendance_date',
        'time_in',
        'time_out',
        'status'
    ];
    
      // Relationship with Child model
      public function child()
      {
          return $this->belongsTo(Children::class, 'children_id');
      }
  
      // Relationship with ParentInfo model
      public function parentInfo()
      {
          return $this->belongsTo(ParentInfo::class, 'parent_infos_id');
      }
}
