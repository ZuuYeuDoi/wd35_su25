<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenitie extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'room_amenities';
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'status'
    ];
}
