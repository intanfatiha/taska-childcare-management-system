<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'child_id', 
        'paymentByParents_date',
        'payment_amount',
        'payment_duedate',
        'payment_status',
        'bill_date',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with the ParentRecord model.
     */
    public function parentRecord()
    {
        return $this->belongsTo(ParentRecord::class, 'parent_id');
    }



    /**
     * Define the relationship with the Child model.
     */
    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }
}