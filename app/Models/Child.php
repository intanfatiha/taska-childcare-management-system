<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    ///** @use HasFactory<\Database\Factories\ChildrenFactory> */
    use HasFactory;
    protected $table = 'childrens';

    protected $fillable = [
        'enrollment_id', 
        'child_name', 
        'child_birthdate', 
        'child_gender', 
        'child_age', 
        'child_address', 
        'child_sibling_number', 
        'child_numberInSibling', 
        'child_allergies', 
        'child_medical_conditions', 
        'child_previous_childcare', 
        'child_birth_cert', 
        'child_immunization_record', 
        'child_photo',
        
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Child belongs to a Registration (which links to parents/guardian)
    public function enrollment() 
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function staffAssignment()
    {
        return $this->hasOne(StaffAssignment::class, 'child_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'children_id');
    }

    public function parentRecords()
    {
        return $this->hasOne(ParentRecord::class, 'child_id');
    }

}
