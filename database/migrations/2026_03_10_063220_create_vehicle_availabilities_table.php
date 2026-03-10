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
        Schema::create('vehicle_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->json('time_slots')->nullable(); // Available time slots
            $table->decimal('special_price', 10, 2)->nullable(); // Special price for this date
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['vehicle_id', 'date']);
            $table->index(['vehicle_id', 'date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_availabilities');
    }
};
