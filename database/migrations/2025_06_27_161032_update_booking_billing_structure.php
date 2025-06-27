<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingBillingStructure extends Migration
{
    public function up()
    {
        // 1. Thêm cột vào bảng bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->dateTime('actual_check_in')->nullable();
            $table->dateTime('actual_check_out')->nullable();
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->text('note')->nullable();
            $table->text('special_request')->nullable();
        });

        // 2. Tạo bảng booking_rooms
        Schema::create('booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('room_id');
            $table->bigInteger('price');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->string('guest_name')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        // 3. Thêm cột vào bảng bills
        Schema::table('bills', function (Blueprint $table) {
            $table->bigInteger('room_amount')->default(0);
            $table->bigInteger('service_amount')->default(0);
            $table->bigInteger('fee_amount')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->tinyInteger('vat_percent')->default(0);
            $table->bigInteger('vat_amount')->default(0);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->dateTime('finalized_at')->nullable();
        });

        // 4. Thêm cột vào bảng payments
        Schema::table('payments', function (Blueprint $table) {
            $table->string('transaction_code')->nullable();
            $table->string('response_code')->nullable();
            $table->bigInteger('amount_paid')->default(0);
        });
    }

    public function down()
    {
        // Rollback changes
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['actual_check_in', 'actual_check_out', 'adults', 'children', 'note', 'special_request']);
        });

        Schema::dropIfExists('booking_rooms');

        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn([
                'room_amount', 'service_amount', 'fee_amount', 'discount',
                'vat_percent', 'vat_amount', 'status', 'finalized_at'
            ]);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['transaction_code', 'response_code', 'amount_paid']);
        });
    }
}

