<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Thêm total_amount vào bảng bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('total_amount')->after('deposit')->nullable();
        });

        // Xoá adults và children khỏi bảng booking_rooms
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->dropColumn(['adults', 'children']);
        });
    }

    public function down(): void
    {
        // Rollback: xoá total_amount
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });

        // Rollback: thêm lại adults và children
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);
        });
    }
};
