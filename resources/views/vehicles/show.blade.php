<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Vehicle Details</h2>
                <small class="text-muted">Complete information of selected vehicle</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                @can('edit_vehicles')
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary btn-sm">
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
                        <div class="mx-auto rounded border bg-light d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="width:180px;height:180px;">
                            @if ($vehicle->thumbnail)
                                <img src="{{ asset('storage/'.$vehicle->thumbnail) }}" alt="Thumbnail" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <i class="bi bi-truck fs-1 text-muted"></i>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                        <p class="text-muted mb-2">{{ $vehicle->registration_number }}</p>

                        <span class="badge text-bg-{{ $vehicle->status === 'available' ? 'success' : ($vehicle->status === 'maintenance' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Basic Information</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><strong>Vendor:</strong> {{ $vehicle->vendor?->name ?: '—' }}</div>
                            <div class="col-md-6"><strong>Category:</strong> {{ $vehicle->category?->name ?: '—' }}</div>
                            <div class="col-md-4"><strong>Year:</strong> {{ $vehicle->year }}</div>
                            <div class="col-md-4"><strong>Fuel:</strong> {{ $vehicle->fuel_type ?: '—' }}</div>
                            <div class="col-md-4"><strong>Transmission:</strong> {{ $vehicle->transmission ?: '—' }}</div>
                            <div class="col-md-4"><strong>Seats:</strong> {{ $vehicle->seating_capacity }}</div>
                            <div class="col-md-4"><strong>City:</strong> {{ $vehicle->city }}</div>
                            <div class="col-md-4"><strong>State:</strong> {{ $vehicle->state }}</div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Pricing</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3"><div class="p-3 bg-light rounded"><small class="text-muted">Hour</small><div class="fw-bold">₹{{ number_format((float) $vehicle->price_per_hour, 2) }}</div></div></div>
                            <div class="col-md-3"><div class="p-3 bg-light rounded"><small class="text-muted">Day</small><div class="fw-bold">₹{{ number_format((float) $vehicle->price_per_day, 2) }}</div></div></div>
                            <div class="col-md-3"><div class="p-3 bg-light rounded"><small class="text-muted">Week</small><div class="fw-bold">₹{{ number_format((float) $vehicle->price_per_week, 2) }}</div></div></div>
                            <div class="col-md-3"><div class="p-3 bg-light rounded"><small class="text-muted">Deposit</small><div class="fw-bold">₹{{ number_format((float) $vehicle->security_deposit, 2) }}</div></div></div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Description & Features</h6></div>
                    <div class="card-body">
                        @if (!empty($vehicle->images))
                            <div class="mb-3">
                                <strong class="d-block mb-2">Gallery:</strong>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($vehicle->images as $image)
                                        <img src="{{ asset('storage/'.$image) }}" alt="Vehicle image" class="rounded border" style="width:92px;height:92px;object-fit:cover;">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <p class="text-muted">{{ $vehicle->description ?: 'No description available.' }}</p>
                        <div>
                            <strong>Features:</strong>
                            @if (!empty($vehicle->features))
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($vehicle->features as $feature)
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
