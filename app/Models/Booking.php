<?php

namespace App\Models;

use App\Models\FeesIncurred;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'room_id',
        'user_id',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'deposit',
        'total_amount',
        'status',
        'special_request',
        'bill_id',
    ];
    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'booking_id');
    }
    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class, 'booking_id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'booking_id');
    }

    public function manageStatusRooms()
    {
        return $this->hasMany(ManageStatusRoom::class);
    }

     public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms', 'booking_id', 'room_id');
    }
    public function feeIncurreds()
{
    return $this->hasMany(FeesIncurred::class, 'booking_id');
}

public function bills()
{
    return $this->hasMany(Bill::class, 'booking_id');
}
public function finalBill()
{
    return $this->hasOne(Bill::class)->where('bill_type', 'final');
}

    
}
