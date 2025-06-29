<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartService extends Model
{
    protected $table = 'cart_service_items';
    protected $fillable = [
        'cart_id',
        'service_id',
        'quantity',
        'unit_price',
        'note',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
