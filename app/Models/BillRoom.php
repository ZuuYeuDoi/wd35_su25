<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'room_name',
        'price_per_night',
        'nights',
        'adults',
        'children',
        'total_price',
        'note',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
