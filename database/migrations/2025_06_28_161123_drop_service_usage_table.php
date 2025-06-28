<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropServiceUsageTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('service_usage');
    }

    public function down(): void
    {
        Schema::create('service_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->dateTime('used_at');
            $table->tinyInteger('status')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
}
