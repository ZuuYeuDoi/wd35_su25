<?php

// database/migrations/2025_07_06_000005_create_bill_fees_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bill_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->string('fee_name');
            $table->text('description')->nullable();
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bill_fees');
    }
};
