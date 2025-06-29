<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillServices extends Model
{
    protected $table = 'bill_services';

    protected $fillable = [
        'bill_id',
        'cart_id',
        'service_name',
        'service_price',
        'quantity',
        'total_price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
