<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'postal_code',
        'date_of_birth',
        'gender',
        'emergency_contact',
        'emergency_phone',
        'bio',
        'documents',
        'preferences',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'documents' => 'array',
        'preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
