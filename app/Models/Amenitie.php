<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenitie extends Model
{
    use HasFactory;

    protected $table = 'room_amenities';
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'status'
    ];
}
