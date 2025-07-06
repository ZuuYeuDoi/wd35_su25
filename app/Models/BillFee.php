<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'fee_name',
        'description',
        'amount',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
