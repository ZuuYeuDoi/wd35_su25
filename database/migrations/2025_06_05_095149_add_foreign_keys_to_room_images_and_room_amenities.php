<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRoomImagesAndRoomAmenities extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm khóa ngoại vào bảng room_images
        Schema::table('room_images', function (Blueprint $table) {
            if (!Schema::hasColumn('room_images', 'room_id')) {
                $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            }
        });

        // Thêm khóa ngoại vào bảng room_amenities
        Schema::table('room_amenities', function (Blueprint $table) {
            if (!Schema::hasColumn('room_amenities', 'room_id')) {
                $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_images', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });

        Schema::table('room_amenities', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });
    }
}
