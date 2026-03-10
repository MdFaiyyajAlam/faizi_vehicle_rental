<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users');
            $table->foreignId('category_id')->constrained('vehicle_categories');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('registration_number')->unique();
            $table->string('chassis_number')->unique()->nullable();
            $table->string('engine_number')->nullable();
            $table->string('color')->nullable();
            $table->integer('seating_capacity');
            $table->string('fuel_type')->nullable(); // Petrol, Diesel, Electric, CNG
            $table->string('transmission')->nullable(); // Manual, Automatic
            $table->decimal('price_per_hour', 10, 2);
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('price_per_week', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->json('features')->nullable();
            $table->json('images')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->json('documents')->nullable(); // RC, Insurance, etc
            $table->enum('status', ['available', 'booked', 'maintenance', 'unavailable'])->default('available');
            $table->json('location_coordinates')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('address')->nullable();
            $table->integer('total_bookings')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['vendor_id', 'category_id', 'status', 'city']);
            $table->index('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
