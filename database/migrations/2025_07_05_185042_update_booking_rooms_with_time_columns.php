<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('booking_rooms', function (Blueprint $table) {
        $table->dateTime('check_in_date')->after('room_id');
        $table->dateTime('check_out_date')->after('check_in_date');
        $table->dateTime('actual_check_in')->nullable()->after('check_out_date');
        $table->dateTime('actual_check_out')->nullable()->after('actual_check_in');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
