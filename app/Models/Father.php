<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Father extends Model
{
    /** @use HasFactory<\Database\Factories\FatherFactory> */
    use HasFactory;

    protected $fillable = [
        'parent_info_id',
        'father_name',
        'father_email',
        'father_phoneNo',
        'father_ic',
        'father_address',
        'father_nationality',
        'father_race',
        'father_religion',
        'father_occupation',
        'father_monthly_income',
        'father_staff_number',
        'father_ptj',
        'father_office_number',
    ];

    // Relationship with ParentInfo (assuming a one-to-one relationship)
    public function parentInfo()
    {
        return $this->belongsTo(ParentInfo::class);
    }
}
