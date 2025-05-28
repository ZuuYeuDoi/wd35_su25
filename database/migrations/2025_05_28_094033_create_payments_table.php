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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id_number');
            $table->unsignedBigInteger('booking_id');
            $table->dateTime('pay_date');
            $table->bigInteger('total_price');
            $table->tinyInteger('payment_status');
            $table->string('payment_method');
            $table->string('vnp_bankcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
