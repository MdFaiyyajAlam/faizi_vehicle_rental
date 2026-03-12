<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $vehicle->brand }} {{ $vehicle->model }} | Faizi Vehicle Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background:#f5f7ff; color:#0f172a; }
        .detail-card { border:0; border-radius:1rem; box-shadow:0 10px 25px rgba(15,23,42,.08); }
        .vehicle-gallery img { height: 430px; object-fit: cover; }
        .chip { background:#eef2ff; color:#3730a3; border-radius:999px; padding:.32rem .7rem; font-size:.8rem; font-weight:600; }
        .price-box { background:linear-gradient(120deg,#1d4ed8,#1e3a8a); color:#fff; border-radius:1rem; }
        .related-card { border:0; border-radius:.9rem; overflow:hidden; box-shadow:0 8px 20px rgba(15,23,42,.08); }
        .related-thumb { height:170px; object-fit:cover; width:100%; }
    </style>
</head>
<body>
    <nav class="navbar bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-car-front-fill text-primary me-1"></i> Faizi Vehicle Rental</a>
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        <div class="mb-3">
            <a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
        </div>

        @php
            $gallery = collect($vehicle->images ?? [])->filter()->values();
            if (!empty($vehicle->thumbnail)) {
                $gallery = collect([$vehicle->thumbnail])->merge($gallery)->unique()->values();
            }
            $carouselId = 'publicVehicleCarousel-'.$vehicle->id;
        @endphp

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card detail-card">
                    <div class="card-body p-0">
                        @if($gallery->isNotEmpty())
                            <div id="{{ $carouselId }}" class="carousel slide vehicle-gallery" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($gallery as $image)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img src="{{ asset('storage/'.$image) }}" class="d-block w-100" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if($gallery->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:430px;">
                                <i class="bi bi-car-front-fill fs-1 text-primary"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card detail-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h1 class="h3 fw-bold mb-0">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                            @if($vehicle->is_featured)
                                <span class="badge text-bg-warning">Featured</span>
                            @endif
                        </div>
                        <p class="text-muted mb-3">{{ $vehicle->year }} • {{ $vehicle->category?->name ?: 'Vehicle' }}</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="chip">{{ $vehicle->fuel_type ?: 'Fuel N/A' }}</span>
                            <span class="chip">{{ $vehicle->transmission ?: 'Transmission N/A' }}</span>
                            <span class="chip">{{ $vehicle->seating_capacity }} Seater</span>
                        </div>

                        <div class="price-box p-3 mb-3">
                            <div class="small text-white-50">Price Per Day</div>
                            <div class="h3 fw-bold mb-0">₹{{ number_format((float) $vehicle->price_per_day, 0) }}</div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('bookings.quick', $vehicle->id) }}" class="btn btn-primary btn-lg"><i class="bi bi-calendar-check me-1"></i> Book Now</a>
                            <a href="{{ route('home') }}#category-{{ $vehicle->category_id }}" class="btn btn-outline-secondary">More in {{ $vehicle->category?->name }}</a>
                        </div>
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-body">
                        <h2 class="h6 fw-bold">Quick Specs</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="py-1"><strong>Vendor:</strong> {{ $vehicle->vendor?->name ?: 'N/A' }}</li>
                            <li class="py-1"><strong>Registration:</strong> {{ $vehicle->registration_number }}</li>
                            <li class="py-1"><strong>Status:</strong> {{ ucfirst($vehicle->status) }}</li>
                            <li class="py-1"><strong>City:</strong> {{ $vehicle->city }}, {{ $vehicle->state }}</li>
                            <li class="py-1"><strong>Security Deposit:</strong> ₹{{ number_format((float) $vehicle->security_deposit, 0) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-4 mt-lg-5">
            <div class="card detail-card">
                <div class="card-body">
                    <h2 class="h5 fw-bold">Description</h2>
                    <p class="text-muted mb-3">{{ $vehicle->description ?: 'No description available for this vehicle.' }}</p>
                    <h3 class="h6 fw-bold">Features</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse(($vehicle->features ?? []) as $feature)
                            <span class="chip">{{ $feature }}</span>
                        @empty
                            <span class="text-muted small">No features listed.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        @if($relatedVehicles->isNotEmpty())
            <section class="mt-4 mt-lg-5">
                <h2 class="h4 fw-bold mb-3">Related Vehicles</h2>
                <div class="row g-3">
                    @foreach($relatedVehicles as $related)
                        @php
                            $relatedImage = $related->thumbnail ?: (collect($related->images ?? [])->first());
                        @endphp
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('home.vehicles.show', $related->id) }}" class="text-decoration-none text-dark">
                                <div class="card related-card h-100">
                                    @if($relatedImage)
                                        <img class="related-thumb" src="{{ asset('storage/'.$relatedImage) }}" alt="{{ $related->brand }} {{ $related->model }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light related-thumb">
                                            <i class="bi bi-car-front-fill text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h3 class="h6 fw-bold mb-1">{{ $related->brand }} {{ $related->model }}</h3>
                                        <p class="small text-muted mb-2">{{ $related->year }} • {{ $related->fuel_type ?: 'Fuel N/A' }}</p>
                                        <span class="fw-bold text-primary">₹{{ number_format((float)$related->price_per_day, 0) }}/day</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
