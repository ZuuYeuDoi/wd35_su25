<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'cccd',
    ];

    // Một guest có thể có nhiều booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
