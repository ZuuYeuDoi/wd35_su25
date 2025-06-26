<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cho phép NULL
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('guest_id')->nullable()->change();
        });

        // 2. Thêm CHECK constraint
        DB::statement("
            ALTER TABLE bookings
            ADD CONSTRAINT chk_user_or_guest 
            CHECK (
                (user_id IS NOT NULL AND guest_id IS NULL) OR 
                (user_id IS NULL AND guest_id IS NOT NULL)
            )
        ");
    }

    public function down(): void
    {
        // 1. Gỡ CHECK constraint (nếu có thể)
        DB::statement("ALTER TABLE bookings DROP CONSTRAINT chk_user_or_guest");

        // 2. Khôi phục lại NOT NULL nếu cần
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('guest_id')->nullable(false)->change();
        });
    }
};
