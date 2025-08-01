<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartServiceItem extends Model
{
    protected $table = 'cart_service_items'; 

    protected $fillable = [
        'cart_id',
        'service_id',
        'quantity',
        'unit_price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}