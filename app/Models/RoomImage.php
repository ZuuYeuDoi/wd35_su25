<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'image_path',
        'order',
        'room_type_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function roomType()
{
    return $this->belongsTo(RoomType::class, 'room_type_id');
}

}
