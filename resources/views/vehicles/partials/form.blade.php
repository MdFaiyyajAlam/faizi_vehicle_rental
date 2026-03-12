@php
    $vehicle = $vehicle ?? null;
    $features = old('features', $vehicle?->features ?? []);
    $existingImages = is_array($vehicle?->images) ? $vehicle->images : [];
    $documents = old('documents', $vehicle?->documents ?? []);
    $coordinates = old('location_coordinates', $vehicle?->location_coordinates ?? []);

    $featuresValue = is_array($features) ? implode(', ', $features) : $features;
    $documentsValue = is_array($documents) ? implode(', ', $documents) : $documents;

    $lat = is_array($coordinates) ? ($coordinates['lat'] ?? null) : null;
    $lng = is_array($coordinates) ? ($coordinates['lng'] ?? null) : null;
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Basic Vehicle Info</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Vendor <span class="text-danger">*</span></label>
                <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                    <option value="">Select vendor</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ (string) old('vendor_id', $vehicle?->vendor_id) === (string) $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>
                @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) old('category_id', $vehicle?->category_id) === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Brand <span class="text-danger">*</span></label>
                <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', $vehicle?->brand) }}" required>
                @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Model <span class="text-danger">*</span></label>
                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $vehicle?->model) }}" required>
                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Year <span class="text-danger">*</span></label>
                <input type="number" name="year" min="1990" max="2100" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $vehicle?->year) }}" required>
                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Registration Number <span class="text-danger">*</span></label>
                <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ old('registration_number', $vehicle?->registration_number) }}" required>
                @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Chassis Number</label>
                <input type="text" name="chassis_number" class="form-control @error('chassis_number') is-invalid @enderror" value="{{ old('chassis_number', $vehicle?->chassis_number) }}">
                @error('chassis_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Engine Number</label>
                <input type="text" name="engine_number" class="form-control @error('engine_number') is-invalid @enderror" value="{{ old('engine_number', $vehicle?->engine_number) }}">
                @error('engine_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Pricing, Status & Specifications</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Price / Hour <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price_per_hour" class="form-control @error('price_per_hour') is-invalid @enderror" value="{{ old('price_per_hour', $vehicle?->price_per_hour) }}" required>
                @error('price_per_hour') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Price / Day <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror" value="{{ old('price_per_day', $vehicle?->price_per_day) }}" required>
                @error('price_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Price / Week <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price_per_week" class="form-control @error('price_per_week') is-invalid @enderror" value="{{ old('price_per_week', $vehicle?->price_per_week) }}" required>
                @error('price_per_week') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Security Deposit</label>
                <input type="number" step="0.01" min="0" name="security_deposit" class="form-control @error('security_deposit') is-invalid @enderror" value="{{ old('security_deposit', $vehicle?->security_deposit ?? 0) }}">
                @error('security_deposit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Seating Capacity <span class="text-danger">*</span></label>
                <input type="number" min="1" name="seating_capacity" class="form-control @error('seating_capacity') is-invalid @enderror" value="{{ old('seating_capacity', $vehicle?->seating_capacity) }}" required>
                @error('seating_capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Fuel Type</label>
                <select name="fuel_type" class="form-select @error('fuel_type') is-invalid @enderror">
                    <option value="">Select</option>
                    @foreach (['Petrol', 'Diesel', 'Electric', 'CNG', 'Hybrid'] as $fuel)
                        <option value="{{ $fuel }}" {{ old('fuel_type', $vehicle?->fuel_type) === $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                    @endforeach
                </select>
                @error('fuel_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Transmission</label>
                <select name="transmission" class="form-select @error('transmission') is-invalid @enderror">
                    <option value="">Select</option>
                    @foreach (['Manual', 'Automatic'] as $trans)
                        <option value="{{ $trans }}" {{ old('transmission', $vehicle?->transmission) === $trans ? 'selected' : '' }}>{{ $trans }}</option>
                    @endforeach
                </select>
                @error('transmission') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach (['available', 'booked', 'maintenance', 'unavailable'] as $status)
                        <option value="{{ $status }}" {{ old('status', $vehicle?->status ?? 'available') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Location, Media & Flags</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">City <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $vehicle?->city) }}" required>
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">State <span class="text-danger">*</span></label>
                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state', $vehicle?->state) }}" required>
                @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $vehicle?->color) }}">
                @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $vehicle?->address) }}</textarea>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Features (comma separated)</label>
                <input type="text" name="features" class="form-control @error('features') is-invalid @enderror" value="{{ $featuresValue }}" placeholder="AC, Airbags, GPS">
                @error('features') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Vehicle Images (multiple upload)</label>
                <input id="imagesInput" type="file" name="images[]" multiple accept="image/*" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror">
                @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <small id="imagesSelectedText" class="text-muted d-block mt-1">No files selected.</small>

                @if (!empty($existingImages))
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach ($existingImages as $image)
                            <img src="{{ asset('storage/'.$image) }}" alt="Vehicle image" class="rounded border" style="width:72px;height:72px;object-fit:cover;">
                        @endforeach
                    </div>
                    <small class="text-muted d-block mt-1">New images upload karne par purani images replace ho jayengi.</small>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Documents (comma separated)</label>
                <input type="text" name="documents" class="form-control @error('documents') is-invalid @enderror" value="{{ $documentsValue }}" placeholder="RC, Insurance">
                @error('documents') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Thumbnail (single image)</label>
                <input id="thumbnailInput" type="file" name="thumbnail" accept="image/*" class="form-control @error('thumbnail') is-invalid @enderror">
                @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small id="thumbnailSelectedText" class="text-muted d-block mt-1">No file selected.</small>

                @if (!empty($vehicle?->thumbnail))
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$vehicle->thumbnail) }}" alt="Thumbnail" class="rounded border" style="width:92px;height:92px;object-fit:cover;">
                    </div>
                @endif
            </div>

            <div class="col-md-3">
                <label class="form-label">Latitude</label>
                <input type="number" step="any" name="location_coordinates[lat]" class="form-control" value="{{ old('location_coordinates.lat', $lat) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Longitude</label>
                <input type="number" step="any" name="location_coordinates[lng]" class="form-control" value="{{ old('location_coordinates.lng', $lng) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Total Bookings</label>
                <input type="number" min="0" name="total_bookings" class="form-control @error('total_bookings') is-invalid @enderror" value="{{ old('total_bookings', $vehicle?->total_bookings ?? 0) }}">
                @error('total_bookings') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Reviews</label>
                <input type="number" min="0" name="total_reviews" class="form-control @error('total_reviews') is-invalid @enderror" value="{{ old('total_reviews', $vehicle?->total_reviews ?? 0) }}">
                @error('total_reviews') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Average Rating</label>
                <input type="number" min="0" max="5" step="0.01" name="average_rating" class="form-control @error('average_rating') is-invalid @enderror" value="{{ old('average_rating', $vehicle?->average_rating ?? 0) }}">
                @error('average_rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-9 d-flex align-items-end gap-4">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_verified" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="isVerifiedSwitch" name="is_verified" value="1" {{ old('is_verified', $vehicle?->is_verified ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isVerifiedSwitch">Verified</label>
                </div>
                <div class="form-check form-switch">
                    <input type="hidden" name="is_featured" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="isFeaturedSwitch" name="is_featured" value="1" {{ old('is_featured', $vehicle?->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isFeaturedSwitch">Featured</label>
                </div>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $vehicle?->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const imagesInput = document.getElementById('imagesInput');
        const imagesSelectedText = document.getElementById('imagesSelectedText');
        const thumbnailInput = document.getElementById('thumbnailInput');
        const thumbnailSelectedText = document.getElementById('thumbnailSelectedText');

        if (imagesInput && imagesSelectedText) {
            imagesInput.addEventListener('change', function () {
                const files = Array.from(this.files || []);

                if (!files.length) {
                    imagesSelectedText.textContent = 'No files selected.';
                    return;
                }

                imagesSelectedText.textContent = 'Selected: ' + files.map(file => file.name).join(', ');
            });
        }

        if (thumbnailInput && thumbnailSelectedText) {
            thumbnailInput.addEventListener('change', function () {
                const file = this.files && this.files[0] ? this.files[0] : null;
                thumbnailSelectedText.textContent = file ? ('Selected: ' + file.name) : 'No file selected.';
            });
        }
    })();
</script>
