<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                    <option value="">Select Vehicle</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $availability->vehicle_id ?? null) == $vehicle->id)>
                            {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->registration_number }})
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Date <span class="text-danger">*</span></label>
                <input
                    type="date"
                    name="date"
                    value="{{ old('date', isset($availability) ? optional($availability->date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                    class="form-control @error('date') is-invalid @enderror"
                    required
                >
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach(['available' => 'Available', 'booked' => 'Booked', 'blocked' => 'Blocked'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $availability->status ?? 'available') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Time Slots (comma separated)</label>
                <input
                    type="text"
                    name="time_slots"
                    value="{{ old('time_slots', isset($availability) && is_array($availability->time_slots) ? implode(', ', $availability->time_slots) : '') }}"
                    class="form-control @error('time_slots') is-invalid @enderror"
                    placeholder="09:00-12:00, 14:00-18:00"
                >
                @error('time_slots') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Special Price (₹)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="special_price"
                    value="{{ old('special_price', $availability->special_price ?? '') }}"
                    class="form-control @error('special_price') is-invalid @enderror"
                    placeholder="Optional"
                >
                @error('special_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Any availability notes...">{{ old('notes', $availability->notes ?? '') }}</textarea>
                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>
