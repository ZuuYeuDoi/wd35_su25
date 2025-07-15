<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'bill_id')) {
                $table->unsignedBigInteger('bill_id')->nullable()->after('special_request');
            }
        });

    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'bill_id')) {
                $table->dropColumn('bill_id');
            }
        });
    }
};
