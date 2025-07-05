<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class RoomType extends Model
{

    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'room_type_price',
        'image',
        'amenities',
        'bed_type',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function images()
{
    return $this->hasMany(RoomImage::class, 'room_type_id');
}

}
