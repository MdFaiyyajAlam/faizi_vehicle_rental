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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('vendor_id')->constrained('users');
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('driver_id')->nullable()->constrained('users');
            $table->enum('booking_type', ['hourly', 'daily', 'weekly']);
            $table->datetime('start_date_time');
            $table->datetime('end_date_time');
            $table->datetime('actual_start_time')->nullable();
            $table->datetime('actual_end_time')->nullable();
            $table->string('pickup_location');
            $table->string('drop_location')->nullable();
            $table->json('location_coordinates')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('extra_charges', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'partial', 'completed', 'refunded'])->default('pending');
            $table->enum('booking_status', [
                'pending', 'confirmed', 'in_progress', 'completed',
                'cancelled', 'refunded', 'no_show'
            ])->default('pending');
            $table->json('cancellation_details')->nullable();
            $table->json('additional_requirements')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('vendor_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'vendor_id', 'vehicle_id', 'booking_status']);
            $table->index('booking_number');
            $table->index(['start_date_time', 'end_date_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
