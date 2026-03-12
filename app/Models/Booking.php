<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number',
        'customer_id',
        'vendor_id',
        'vehicle_id',
        'driver_id',
        'booking_type',
        'start_date_time',
        'end_date_time',
        'actual_start_time',
        'actual_end_time',
        'pickup_location',
        'drop_location',
        'location_coordinates',
        'base_price',
        'extra_charges',
        'tax_amount',
        'discount_amount',
        'security_deposit',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'booking_status',
        'cancellation_details',
        'additional_requirements',
        'special_requests',
        'vendor_notes',
        'admin_notes',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
        'actual_start_time' => 'datetime',
        'actual_end_time' => 'datetime',
        'location_coordinates' => 'array',
        'base_price' => 'decimal:2',
        'extra_charges' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'cancellation_details' => 'array',
        'additional_requirements' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
