<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'room_id',
        'user_id',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'deposit',
        'status',
    ];

    // Quan hệ với phòng
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Quan hệ với người dùng (admin hoặc người đặt)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với khách (guest)
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
