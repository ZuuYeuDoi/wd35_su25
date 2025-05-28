<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
           $table->id();
            $table->string('bill_code');
            $table->unsignedBigInteger('booking_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('cccd');
            $table->string('room');
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');
            $table->bigInteger('final_amount');
            $table->string('payment_method');
            $table->dateTime('payment_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
