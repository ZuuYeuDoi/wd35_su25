<?php

namespace App\Models;

use App\Models\CartService;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'booking_id',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function services()
    {
        return $this->hasMany(CartService::class, 'cart_id');
    }

    public function cartServiceItems()
    {
        return $this->hasMany(CartServiceItem::class);
    }

        
}
