<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBillsTable extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            // Thêm user_id (nullable) nếu bạn muốn theo dõi ai tạo hóa đơn
            $table->foreignId('user_id')->nullable()->after('booking_id')->constrained()->nullOnDelete();

            // Xoá các cột dư thừa (đã có trong bookings hoặc users)
            $table->dropColumn([
                'name',
                'email',
                'phone',
                'cccd',
                'room',
                'check_in_date',
                'check_out_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            // Thêm lại các cột đã xóa
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('cccd');
            $table->string('room');
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');

            // Xoá user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
