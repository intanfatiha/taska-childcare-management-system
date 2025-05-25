<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentRecord extends Model
{
    //
    protected $fillable = [
        'enrollment_id',
        'father_id',
        'mother_id',
        'guardian_id',
        'child_id',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    // Relationship with Father
    public function father()
    {
        return $this->belongsTo(Father::class, 'father_id');
    }

    // Relationship with Mother
    public function mother()
    {
        return $this->belongsTo(Mother::class, 'mother_id');
    }

    // Relationship with Guardian
    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    // Relationship with Child
    // public function child()
    // {
    //     return $this->belongsTo(Child::class, 'enrollment_id','id');
    // }

    public function child()
    {
        return $this->belongsTo(Child::class,'child_id');
    }
}
