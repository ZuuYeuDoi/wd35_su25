<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRoomIdFromBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_id']); // nếu có khóa ngoại
            $table->dropColumn('room_id');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->after('booking_code');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }
}
