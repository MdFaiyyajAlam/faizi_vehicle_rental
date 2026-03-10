@php
    $vehicleCategory = $vehicleCategory ?? null;
    $features = old('features', $vehicleCategory?->features ?? []);
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
        <h5 class="mb-0 fw-semibold">Basic Information</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vehicleCategory?->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $vehicleCategory?->slug) }}" placeholder="auto-generated-if-empty">
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $vehicleCategory?->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Icon</label>
                <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $vehicleCategory?->icon) }}" placeholder="e.g. bi-car-front-fill">
                @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Category Image</label>
                <input type="file" name="image_file" accept="image/*" class="form-control @error('image_file') is-invalid @enderror">
                @error('image_file') <div class="invalid-feedback">{{ $message }}</div> @enderror

                @if ($vehicleCategory?->image)
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <img src="{{ Storage::url($vehicleCategory->image) }}" alt="Category Image" class="rounded border" style="width:64px;height:64px;object-fit:cover;">
                        <small class="text-muted">Current image</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Pricing & Booking Rules</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Price / Hour <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="base_price_per_hour" class="form-control @error('base_price_per_hour') is-invalid @enderror" value="{{ old('base_price_per_hour', $vehicleCategory?->base_price_per_hour) }}" required>
                @error('base_price_per_hour') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Price / Day <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="base_price_per_day" class="form-control @error('base_price_per_day') is-invalid @enderror" value="{{ old('base_price_per_day', $vehicleCategory?->base_price_per_day) }}" required>
                @error('base_price_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Price / Week <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="base_price_per_week" class="form-control @error('base_price_per_week') is-invalid @enderror" value="{{ old('base_price_per_week', $vehicleCategory?->base_price_per_week) }}" required>
                @error('base_price_per_week') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Security Deposit</label>
                <input type="number" step="0.01" min="0" name="security_deposit" class="form-control @error('security_deposit') is-invalid @enderror" value="{{ old('security_deposit', $vehicleCategory?->security_deposit ?? 0) }}">
                @error('security_deposit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Min Booking Hours</label>
                <input type="number" min="1" name="min_booking_hours" class="form-control @error('min_booking_hours') is-invalid @enderror" value="{{ old('min_booking_hours', $vehicleCategory?->min_booking_hours ?? 1) }}">
                @error('min_booking_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Max Booking Days</label>
                <input type="number" min="1" name="max_booking_days" class="form-control @error('max_booking_days') is-invalid @enderror" value="{{ old('max_booking_days', $vehicleCategory?->max_booking_days) }}">
                @error('max_booking_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Additional Settings</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Features (comma separated)</label>
                <input type="text" name="features[]" class="form-control @error('features') is-invalid @enderror" value="{{ is_array($features) ? implode(', ', $features) : $features }}" placeholder="AC, Airbags, Music System">
                @error('features') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Sort Order</label>
                <input type="number" min="0" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $vehicleCategory?->sort_order ?? 0) }}">
                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <input type="hidden" name="is_active" value="0">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="isActiveSwitch" name="is_active" value="1" {{ old('is_active', $vehicleCategory?->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActiveSwitch">Active Category</label>
                </div>
            </div>
        </div>
    </div>
</div>
