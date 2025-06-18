<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

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
}
