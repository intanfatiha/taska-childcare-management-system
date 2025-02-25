<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentInfo extends Model
{
    /** @use HasFactory<\Database\Factories\ParentInfoFactory> */
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
