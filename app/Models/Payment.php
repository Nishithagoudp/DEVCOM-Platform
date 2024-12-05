<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'payment_status',
        'payable_type',  // Added payable_type
        'payable_id',
        'payment_methods',
        'user_id'
    ];
    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user associated with this payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

