<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Vehicle Category Details</h2>
                <small class="text-muted">Complete information of selected category</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('vehicle-categories.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                @can('edit_categories')
                    <a href="{{ route('vehicle-categories.edit', $vehicleCategory->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        @if ($vehicleCategory->image)
                            <img src="{{ Storage::url($vehicleCategory->image) }}" alt="{{ $vehicleCategory->name }}" class="rounded border mb-3" style="width:180px;height:180px;object-fit:cover;">
                        @else
                            <div class="mx-auto rounded border bg-light d-flex align-items-center justify-content-center mb-3" style="width:180px;height:180px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                        @endif

                        <h5 class="fw-bold mb-1">{{ $vehicleCategory->name }}</h5>
                        <p class="text-muted mb-2">Slug: {{ $vehicleCategory->slug }}</p>

                        <span class="badge {{ $vehicleCategory->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $vehicleCategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-semibold">Description</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $vehicleCategory->description ?: 'No description available.' }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-semibold">Pricing Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Price / Hour</small><div class="fw-bold">₹{{ number_format((float) $vehicleCategory->base_price_per_hour, 2) }}</div></div></div>
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Price / Day</small><div class="fw-bold">₹{{ number_format((float) $vehicleCategory->base_price_per_day, 2) }}</div></div></div>
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Price / Week</small><div class="fw-bold">₹{{ number_format((float) $vehicleCategory->base_price_per_week, 2) }}</div></div></div>
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Security Deposit</small><div class="fw-bold">₹{{ number_format((float) $vehicleCategory->security_deposit, 2) }}</div></div></div>
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Min Booking Hours</small><div class="fw-bold">{{ $vehicleCategory->min_booking_hours ?? '—' }}</div></div></div>
                            <div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">Max Booking Days</small><div class="fw-bold">{{ $vehicleCategory->max_booking_days ?? '—' }}</div></div></div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-semibold">Additional Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Icon:</strong> {{ $vehicleCategory->icon ?: '—' }}</div>
                        <div class="mb-2"><strong>Sort Order:</strong> {{ $vehicleCategory->sort_order ?? 0 }}</div>
                        <div>
                            <strong>Features:</strong>
                            @if (!empty($vehicleCategory->features))
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($vehicleCategory->features as $feature)
                                        <span class="badge text-bg-light border text-dark">{{ $feature }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted"> — </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
