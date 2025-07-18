<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesIncurred extends Model
{
    use HasFactory;

    protected $table = 'fees_incurred';

    protected $fillable = [
        'booking_id',
        'name',
        'description',
        'price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
