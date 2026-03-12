<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateVehicleAvailabilityRequest extends StoreVehicleAvailabilityRequest
{
    public function rules(): array
    {
        $id = (int) $this->route('id');

        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'date' => [
                'required',
                'date',
                Rule::unique('vehicle_availabilities')
                    ->ignore($id)
                    ->where(fn ($query) => $query->where('vehicle_id', $this->input('vehicle_id'))),
            ],
            'status' => ['required', Rule::in(['available', 'booked', 'blocked'])],
            'time_slots' => ['nullable'],
            'special_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
