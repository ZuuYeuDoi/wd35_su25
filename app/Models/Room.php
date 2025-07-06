<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_AVAILABLE = 0;
    const STATUS_OCCUPIED = 1;
    const STATUS_MAINTENANCE = 2;
    
    const STATUS_ALREADYBOOKED = 3;


    protected $fillable = [
        'room_type_id',
        'title',
        'price',
        'max_people',
        'image_room',
        'thumbnail',
        'description',
        'status',
        'amenities'
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function images_room()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function statusHistories()
{
    return $this->hasMany(ManageStatusRoom::class);
}
}
