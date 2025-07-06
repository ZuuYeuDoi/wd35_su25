<?php
// database/migrations/2025_07_06_000002_create_bills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_code');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('payment_method');
            $table->dateTime('payment_date');
            $table->text('note')->nullable();

            $table->bigInteger('room_amount')->default(0);
            $table->bigInteger('service_amount')->default(0);
            $table->bigInteger('fee_amount')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->tinyInteger('vat_percent')->default(0);
            $table->bigInteger('vat_amount')->default(0);

            $table->bigInteger('final_amount');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('paid');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bills');
    }
};
