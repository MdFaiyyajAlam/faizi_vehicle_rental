<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:users,id'],
            'vendor_id' => ['required', 'integer', 'exists:users,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'driver_id' => ['nullable', 'integer', 'exists:users,id'],
            'booking_type' => ['required', Rule::in(['hourly', 'daily', 'weekly'])],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date', 'after:start_date_time'],
            'actual_start_time' => ['nullable', 'date'],
            'actual_end_time' => ['nullable', 'date', 'after_or_equal:actual_start_time'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'drop_location' => ['nullable', 'string', 'max:255'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'extra_charges' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'booking_status' => ['nullable', Rule::in(['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'refunded', 'no_show'])],
            'special_requests' => ['nullable', 'string'],
            'vendor_notes' => ['nullable', 'string'],
            'admin_notes' => ['nullable', 'string'],
            'additional_requirements' => ['nullable'],
        ];
    }
}
