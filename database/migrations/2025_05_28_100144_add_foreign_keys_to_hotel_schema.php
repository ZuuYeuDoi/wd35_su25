<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // payments ↔ bookings
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        // bookings ↔ rooms, users, guests
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
        });

        // user ↔ roles
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });

        // review ↔ user, room
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        // rooms ↔ room_type
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('set null');
        });

        // room_assets ↔ rooms, asset_type
        Schema::table('room_assets', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('asset_type_id')->references('id')->on('asset_types')->onDelete('cascade');
        });

        // fee_incurred ↔ bookings
        Schema::table('fees_incurred', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        // manage_status_rooms ↔ bookings, rooms
        Schema::table('manage_status_rooms', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        // bills_services ↔ bills
        Schema::table('bill_services', function (Blueprint $table) {
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
        });

        // notifications ↔ user
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // service_usage ↔ bookings, services
        Schema::table('service_usage', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['guest_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['room_type_id']);
        });

        Schema::table('room_assets', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['asset_type_id']);
        });

        Schema::table('fees_incurred', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
        });

        Schema::table('manage_status_rooms', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropForeign(['room_id']);
        });

        Schema::table('bill_services', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('service_usage', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropForeign(['service_id']);
        });
    }
};
