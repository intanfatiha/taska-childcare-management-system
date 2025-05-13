<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    /** @use HasFactory<\Database\Factories\MotherFactory> */
    use HasFactory;

      // Define the fillable attributes
      protected $fillable = [
        'enrollment_id',
        'mother_name',
        'mother_email',
        'mother_phoneNo',
        'mother_ic',
        'mother_address',
        'mother_nationality',
        'mother_race',
        'mother_religion',
        'mother_occupation',
        'mother_monthly_income',
        'mother_staff_number',
        'mother_ptj',
        'mother_office_number',
    ];

     // Relationship with registration (assuming a one-to-one relationship)
     public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function parentRecord()
    {
        return $this->hasMany(ParentRecord::class, 'mother_id');
    }
}
