<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageStatusRoom extends Model
{
    use HasFactory;

    protected $table = 'manage_status_rooms';

    protected $fillable = [
        'room_id',
        'booking_id',
        'status',
        'from',
        'to',
        'note',
    ];

    protected $dates = ['from_date', 'to_date'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    const STATUS_CHECKIN = 0;
    const STATUS_CHECKOUT = 1;
    const STATUS_REPAIR = 2;
    const STATUS_CLEANING = 3;
}
