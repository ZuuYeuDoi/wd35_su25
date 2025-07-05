<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('room_images', function (Blueprint $table) {
            // Cho phép room_id nullable
            $table->unsignedBigInteger('room_id')->nullable()->change();

            // Thêm khóa ngoại room_type_id
            $table->foreignId('room_type_id')->nullable()->constrained('room_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('room_images', function (Blueprint $table) {
            // Rollback lại room_id về not null nếu cần
            $table->unsignedBigInteger('room_id')->nullable(false)->change();

            $table->dropForeign(['room_type_id']);
            $table->dropColumn('room_type_id');
        });
    }
};
