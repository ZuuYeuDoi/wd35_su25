<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit',
        'image',
        'status',
        'type',
        'quantity',
    ];

    const TYPE = [
        '1' => 'Lưu trú', // VD giặt là, dọn dẹp vệ sinh phòng ...
        '2' => 'Ẩm thực', // Đồ ăn đồ uống
        '3' => 'Bổ sung', // Đưa đón sân bay, gữi hành lý, thuê xe, hướng dẫn viên ...
        '4' => 'Giải trí - chăm sóc', //  Spa, massage, gym, yoga, hồ bơi, xông hơi ...
    ];

    public function cartItems()
{
    return $this->hasMany(CartService::class,'');
}
}
