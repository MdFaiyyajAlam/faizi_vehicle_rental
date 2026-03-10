<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'brand',
        'model',
        'year',
        'registration_number',
        'chassis_number',
        'engine_number',
        'color',
        'seating_capacity',
        'fuel_type',
        'transmission',
        'price_per_hour',
        'price_per_day',
        'price_per_week',
        'security_deposit',
        'features',
        'images',
        'thumbnail',
        'description',
        'documents',
        'status',
        'location_coordinates',
        'city',
        'state',
        'address',
        'total_bookings',
        'average_rating',
        'total_reviews',
        'is_verified',
        'is_featured',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'documents' => 'array',
        'location_coordinates' => 'array',
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'price_per_week' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
