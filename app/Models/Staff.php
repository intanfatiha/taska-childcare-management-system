<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_name',
        'staff_ic',
        'staff_email',
        'staff_phoneno',
        'staff_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}