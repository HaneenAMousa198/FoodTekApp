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
    Schema::create('deliveries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('staff_id')->constrained()->onDelete('cascade');
        $table->string('driver_name');
        $table->string('status');
        $table->timestamp('status_time');
        $table->string('delivery_address');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('deliveries'); // ✅ تصحيح التهجئة
}
};