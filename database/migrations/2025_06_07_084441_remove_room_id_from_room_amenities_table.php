<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_amenities', function (Blueprint $table) {
            $table->dropForeign(['room_id']); // Xóa khóa ngoại trước
            $table->dropColumn('room_id');    // Sau đó xóa cột
        });
    }

    public function down(): void
    {
        Schema::table('room_amenities', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained('rooms'); // Khôi phục nếu rollback
        });
    }
};
