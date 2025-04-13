<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssignment extends Model
{
    use HasFactory;

    protected $table = 'staff_assigments';
    
    protected $fillable = [
        'child_id',
        'primary_staff_id',
        'status'
    ];

    /**
     * Get the child associated with the assignment.
     */
    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    /**
     * Get the staff member associated with the assignment.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'primary_staff_id');
    }
}