<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xoá ràng buộc khoá ngoại trước rồi mới xoá cột
            if (Schema::hasColumn('reviews', 'booking_id')) {
                $table->dropForeign(['booking_id']);
                $table->dropColumn('booking_id');
            }
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('booking_id')
                ->nullable()
                ->after('user_id')
                ->constrained('bookings')
                ->onDelete('cascade');
        });
    }
};
