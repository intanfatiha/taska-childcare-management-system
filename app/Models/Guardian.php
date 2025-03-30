<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    /** @use HasFactory<\Database\Factories\GuardianFactory> */
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = [
        'enrollment_id',
        'guardian_name',
        'guardian_relation',
        'guardian_email',
        'guardian_phoneNo',
        'guardian_ic',
        'guardian_address',
        'guardian_nationality',
        'guardian_race',
        'guardian_religion',
        'guardian_occupation',
        'guardian_monthly_income',
        'guardian_staff_number',
        'guardian_ptj',
        'guardian_office_number',
        
    ];

    // Relationship with ParentInfo (assuming a one-to-one relationship)
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
