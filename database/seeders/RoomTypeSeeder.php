<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'type' => 'Standard',
                'name' => 'Phòng Tiêu Chuẩn',
                'room_type_price' => 1000000,
                'image' => 'standard-room.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Deluxe',
                'name' => 'Phòng Deluxe',
                'room_type_price' => 1500000,
                'image' => 'deluxe-room.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Suite',
                'name' => 'Phòng Suite',
                'room_type_price' => 2000000,
                'image' => 'suite-room.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Executive',
                'name' => 'Phòng Executive',
                'room_type_price' => 2500000,
                'image' => 'executive-room.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Presidential',
                'name' => 'Phòng Tổng Thống',
                'room_type_price' => 5000000,
                'image' => 'presidential-room.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('room_types')->insert($roomTypes);
    }
}
