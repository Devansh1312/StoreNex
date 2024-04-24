<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'razorpay_order_id' ,'razorpay_payment_id','status',
        'user_id', 'name', 'email', 'phone', 'addressline1', 'addressline2',
        'city', 'district', 'zip_code', 'order_status', 'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

}

