<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'features',
        'base_price_per_hour',
        'base_price_per_day',
        'base_price_per_week',
        'security_deposit',
        'min_booking_hours',
        'max_booking_days',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'base_price_per_hour' => 'decimal:2',
        'base_price_per_day' => 'decimal:2',
        'base_price_per_week' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'category_id');
    }
}
