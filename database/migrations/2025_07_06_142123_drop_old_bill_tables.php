<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('bill_services');
        Schema::dropIfExists('bills');
    }

    public function down(): void {
        // Optional: tái tạo lại nếu cần rollback
    }
};
