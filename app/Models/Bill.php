<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_code',
        'customer_name',
        'customer_phone',
        'payment_method',
        'payment_date',
        'note',
        'room_amount',
        'service_amount',
        'fee_amount',
        'discount',
        'vat_percent',
        'vat_amount',
        'final_amount',
        'status',
    ];

    public function services()
    {
        return $this->hasMany(BillService::class);
    }

    public function rooms()
    {
        return $this->hasMany(BillRoom::class);
    }

    public function fees()
    {
        return $this->hasMany(BillFee::class);
    }

    protected $casts = [
    'payment_date' => 'datetime',
    ];
}