<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingRoom extends Model
{
    use HasFactory;

    protected $table = 'booking_rooms';

    protected $fillable = [
        'booking_id',
        'room_id',
        'price',
        'adults',
        'check_in_date',
        'check_out_date',
        'children',
        'guest_name',
        'note',
        'cccd',
    ];

    // Quan hệ: BookingRoom thuộc về 1 Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Quan hệ: BookingRoom thuộc về 1 Room
    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }
}
