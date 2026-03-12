<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'date',
        'status',
        'time_slots',
        'special_price',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'time_slots' => 'array',
        'special_price' => 'decimal:2',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
