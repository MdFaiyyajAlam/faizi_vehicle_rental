<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faizi Vehicle Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background: #f4f7fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-section {
            background: linear-gradient(120deg, #0f172a 0%, #1d4ed8 60%, #2563eb 100%);
            color: #fff; border-radius: 1.25rem; overflow: hidden;
            box-shadow: 0 14px 40px rgba(15, 23, 42, .22);
        }
        .glass-stat {
            background: rgba(255, 255, 255, .12); backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .18); border-radius: .85rem;
        }
        .section-title { font-weight: 700; letter-spacing: .2px; }
        .category-chip {
            background: #fff; border: 1px solid #dbe4f0; border-radius: 999px;
            padding: .45rem .9rem; color: #1e293b; font-weight: 600; font-size: .85rem;
        }
        .vehicle-card {
            border: 0; border-radius: 1rem; box-shadow: 0 8px 28px rgba(15, 23, 42, .08);
            overflow: hidden; height: 100%; transition: transform .2s ease, box-shadow .2s ease;
        }
        .vehicle-card:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(15, 23, 42, .14); }
        .vehicle-thumb {
            height: 170px; background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            display: flex; align-items: center; justify-content: center; color: #1d4ed8;
        }
        .price-badge { background: #eef2ff; color: #3730a3; border-radius: .6rem; font-weight: 700; }
        .category-block { scroll-margin-top: 90px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill text-primary me-1"></i> Faizi Vehicle Rental
            </a>

            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-4 py-lg-5">
        <section class="hero-section p-4 p-md-5 mb-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-light text-primary fw-semibold mb-3">Trusted Self-Drive & Chauffeur Rentals</span>
                    <h1 class="display-5 fw-bold mb-3">Book Premium Vehicles by Category, in Minutes</h1>
                    <p class="lead text-white-50 mb-4">Choose your category, compare vehicles, and book instantly. If you're not logged in, we'll redirect you to register first and continue booking smoothly.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#categories" class="btn btn-light btn-lg px-4">Explore Categories</a>
                        @auth
                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-light btn-lg">Start Booking</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Create Free Account</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6"><div class="glass-stat p-3 text-center"><h4 class="mb-0 fw-bold">{{ $categories->count() }}</h4><small>Categories</small></div></div>
                        <div class="col-6"><div class="glass-stat p-3 text-center"><h4 class="mb-0 fw-bold">{{ $categories->sum(fn($cat) => $cat->vehicles->count()) }}</h4><small>Listed Vehicles</small></div></div>
                        <div class="col-6"><div class="glass-stat p-3 text-center"><h4 class="mb-0 fw-bold">24/7</h4><small>Support</small></div></div>
                        <div class="col-6"><div class="glass-stat p-3 text-center"><h4 class="mb-0 fw-bold">4.9★</h4><small>Avg Experience</small></div></div>
                    </div>
                </div>
            </div>
        </section>

        @if($categories->isNotEmpty())
            <section id="categories" class="mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <h2 class="section-title h3 mb-0">Browse by Category</h2>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <a class="text-decoration-none category-chip" href="#category-{{ $category->id }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </section>

            @foreach($categories as $category)
                <section class="mb-5 category-block" id="category-{{ $category->id }}">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h3 class="h4 fw-bold mb-1">{{ $category->name }}</h3>
                            <p class="text-muted mb-0">{{ $category->description ?: 'Top options in this category for your next ride.' }}</p>
                        </div>
                        <span class="badge text-bg-primary">{{ $category->vehicles->count() }} vehicles</span>
                    </div>

                    <div class="row g-4">
                        @forelse($category->vehicles as $vehicle)
                            <div class="col-md-6 col-lg-3">
                                <div class="card vehicle-card">
                                    <div class="vehicle-thumb">
                                        <i class="bi bi-car-front-fill fs-1"></i>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0 fw-semibold">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                            @if($vehicle->is_featured)
                                                <span class="badge text-bg-warning">Featured</span>
                                            @endif
                                        </div>

                                        <p class="text-muted small mb-3">{{ $vehicle->year }} • {{ $vehicle->fuel_type ?: 'Fuel N/A' }} • {{ $vehicle->transmission ?: 'Transmission N/A' }}</p>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="px-2 py-1 price-badge">₹{{ number_format((float)$vehicle->price_per_day, 0) }}/day</span>
                                            <a href="{{ route('bookings.quick', $vehicle->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-calendar-check me-1"></i> Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border text-muted mb-0">No available vehicles in this category right now.</div>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        @endif

        @if($featuredVehicles->isNotEmpty())
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h3 mb-0">Featured Vehicles</h2>
                    <span class="text-muted small">Handpicked premium options</span>
                </div>
                <div class="row g-4">
                    @foreach($featuredVehicles as $vehicle)
                        <div class="col-md-6 col-lg-4">
                            <div class="card vehicle-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-semibold mb-0">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                        <span class="badge text-bg-info">{{ $vehicle->category?->name }}</span>
                                    </div>
                                    <p class="text-muted small mb-3">{{ $vehicle->city }}, {{ $vehicle->state }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary">₹{{ number_format((float)$vehicle->price_per_day, 0) }}/day</span>
                                        <a href="{{ route('bookings.quick', $vehicle->id) }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>© {{ date('Y') }} Faizi Vehicle Rental. All rights reserved.</span>
            <span class="text-secondary">Professional rentals for every journey.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
