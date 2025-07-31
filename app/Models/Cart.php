<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'booking_id',
        'status',
        'user_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function cartServiceItems()
    {
        return $this->hasMany(CartServiceItem::class, 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
