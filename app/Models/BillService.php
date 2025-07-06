<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillService extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'service_name',
        'unit_price',
        'quantity',
        'total_price',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
