<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Customer <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $booking->customer_id ?? ($defaults['customer_id'] ?? null)) == $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
                @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Vendor <span class="text-danger">*</span></label>
                <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" @selected(old('vendor_id', $booking->vendor_id ?? ($defaults['vendor_id'] ?? null)) == $vendor->id)>{{ $vendor->name }}</option>
                    @endforeach
                </select>
                @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                    <option value="">Select Vehicle</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $booking->vehicle_id ?? ($defaults['vehicle_id'] ?? null)) == $vehicle->id)>
                            {{ $vehicle->brand }} {{ $vehicle->model }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Driver</label>
                <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
                    <option value="">Select Driver</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" @selected(old('driver_id', $booking->driver_id ?? null) == $driver->id)>{{ $driver->name }}</option>
                    @endforeach
                </select>
                @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Booking Type <span class="text-danger">*</span></label>
                <select name="booking_type" class="form-select @error('booking_type') is-invalid @enderror" required>
                    @foreach(['hourly' => 'Hourly', 'daily' => 'Daily', 'weekly' => 'Weekly'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('booking_type', $booking->booking_type ?? 'daily') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('booking_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Start Date Time <span class="text-danger">*</span></label>
                <input type="datetime-local" name="start_date_time" class="form-control @error('start_date_time') is-invalid @enderror"
                    value="{{ old('start_date_time', isset($booking) && $booking->start_date_time ? $booking->start_date_time->format('Y-m-d\TH:i') : '') }}" required>
                @error('start_date_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">End Date Time <span class="text-danger">*</span></label>
                <input type="datetime-local" name="end_date_time" class="form-control @error('end_date_time') is-invalid @enderror"
                    value="{{ old('end_date_time', isset($booking) && $booking->end_date_time ? $booking->end_date_time->format('Y-m-d\TH:i') : '') }}" required>
                @error('end_date_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Booking Status</label>
                <select name="booking_status" class="form-select @error('booking_status') is-invalid @enderror">
                    @foreach(['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'refunded', 'no_show'] as $status)
                        <option value="{{ $status }}" @selected(old('booking_status', $booking->booking_status ?? 'pending') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
                @error('booking_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Pickup Location <span class="text-danger">*</span></label>
                <input type="text" name="pickup_location" class="form-control @error('pickup_location') is-invalid @enderror" value="{{ old('pickup_location', $booking->pickup_location ?? '') }}" required>
                @error('pickup_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Drop Location</label>
                <input type="text" name="drop_location" class="form-control @error('drop_location') is-invalid @enderror" value="{{ old('drop_location', $booking->drop_location ?? '') }}">
                @error('drop_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Base Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="base_price" class="form-control @error('base_price') is-invalid @enderror" value="{{ old('base_price', $booking->base_price ?? 0) }}" required>
                @error('base_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Extra Charges</label>
                <input type="number" step="0.01" min="0" name="extra_charges" class="form-control @error('extra_charges') is-invalid @enderror" value="{{ old('extra_charges', $booking->extra_charges ?? 0) }}">
                @error('extra_charges') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Tax</label>
                <input type="number" step="0.01" min="0" name="tax_amount" class="form-control @error('tax_amount') is-invalid @enderror" value="{{ old('tax_amount', $booking->tax_amount ?? 0) }}">
                @error('tax_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Discount</label>
                <input type="number" step="0.01" min="0" name="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" value="{{ old('discount_amount', $booking->discount_amount ?? 0) }}">
                @error('discount_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Deposit</label>
                <input type="number" step="0.01" min="0" name="security_deposit" class="form-control @error('security_deposit') is-invalid @enderror" value="{{ old('security_deposit', $booking->security_deposit ?? 0) }}">
                @error('security_deposit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label">Paid Amount</label>
                <input type="number" step="0.01" min="0" name="paid_amount" class="form-control @error('paid_amount') is-invalid @enderror" value="{{ old('paid_amount', $booking->paid_amount ?? 0) }}">
                @error('paid_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Additional Requirements (comma separated)</label>
                <input type="text" name="additional_requirements" class="form-control @error('additional_requirements') is-invalid @enderror"
                    value="{{ old('additional_requirements', isset($booking) && is_array($booking->additional_requirements) ? implode(', ', $booking->additional_requirements) : '') }}"
                    placeholder="Baby seat, extra luggage rack">
                @error('additional_requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Special Requests</label>
                <textarea name="special_requests" rows="2" class="form-control @error('special_requests') is-invalid @enderror">{{ old('special_requests', $booking->special_requests ?? '') }}</textarea>
                @error('special_requests') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>
