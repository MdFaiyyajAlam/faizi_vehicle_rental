<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'date' => [
                'required',
                'date',
                Rule::unique('vehicle_availabilities')->where(fn ($query) => $query->where('vehicle_id', $this->input('vehicle_id'))),
            ],
            'status' => ['required', Rule::in(['available', 'booked', 'blocked'])],
            'time_slots' => ['nullable'],
            'special_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
