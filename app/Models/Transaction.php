<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function formattedDate()
    {
        return Carbon::parse($this->created_at)->format('DD-MMM-YYYY hh:mm A');
    }

}

