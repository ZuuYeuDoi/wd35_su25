<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

     protected $primaryKey = 'payment_id_number';

    protected $fillable = [
        'booking_id',
        'pay_date',
        'total_price',
        'payment_status',
        'payment_method',
        'vnp_bankcode',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
