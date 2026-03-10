<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends StoreVehicleRequest
{
    public function rules(): array
    {
        $id = (int) $this->route('id');

        return [
            'vendor_id' => ['required', 'integer', 'exists:users,id'],
            'category_id' => ['required', 'integer', 'exists:vehicle_categories,id'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1990', 'max:2100'],
            'registration_number' => ['required', 'string', 'max:255', Rule::unique('vehicles', 'registration_number')->ignore($id)],
            'chassis_number' => ['nullable', 'string', 'max:255', Rule::unique('vehicles', 'chassis_number')->ignore($id)],
            'engine_number' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:100'],
            'seating_capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'fuel_type' => ['nullable', Rule::in(['Petrol', 'Diesel', 'Electric', 'CNG', 'Hybrid'])],
            'transmission' => ['nullable', Rule::in(['Manual', 'Automatic'])],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'price_per_week' => ['required', 'numeric', 'min:0'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'features' => ['nullable'],
            'images' => ['nullable'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'documents' => ['nullable'],
            'status' => ['nullable', Rule::in(['available', 'booked', 'maintenance', 'unavailable'])],
            'location_coordinates' => ['nullable'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'total_bookings' => ['nullable', 'integer', 'min:0'],
            'average_rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'is_verified' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
