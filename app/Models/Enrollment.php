<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    // use SoftDeletes; //this can delete and restore

    /** @use HasFactory<\Database\Factories\RegistrationFactory> */
    use HasFactory;
    protected $fillable = [
        'status',
        'registration_type',
       
    ];

    public function child()
    {
        return $this->hasMany(Child::class);
    }

    public function father()
    {
        return $this->hasOne(Father::class);
    }

    public function mother()
    {
        return $this->hasOne(Mother::class);
    }

// A registration has one guardian (if applicable)
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

}
