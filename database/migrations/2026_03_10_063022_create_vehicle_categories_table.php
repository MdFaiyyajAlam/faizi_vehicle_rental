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
        Schema::create('vehicle_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Truck, Pickup, Auto, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->json('features')->nullable(); // AC/Non-AC, Capacity etc
            $table->decimal('base_price_per_hour', 10, 2);
            $table->decimal('base_price_per_day', 10, 2);
            $table->decimal('base_price_per_week', 10, 2);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->integer('min_booking_hours')->default(1);
            $table->integer('max_booking_days')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_categories');
    }
};
