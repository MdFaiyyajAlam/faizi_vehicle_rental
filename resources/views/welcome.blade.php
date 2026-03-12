<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faizi Vehicle Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brand: #1d4ed8;
            --brand-dark: #1e3a8a;
            --soft-bg: #f6f8ff;
            --text-muted: #6b7280;
        }

        body {
            background: var(--soft-bg);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .top-strip {
            background: #0f172a;
            color: #dbeafe;
            font-size: .85rem;
        }

        .main-nav {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, .95);
        }

        .hero-wrap {
            background: radial-gradient(circle at right top, #2563eb 0%, #1d4ed8 45%, #0f172a 100%);
            border-radius: 1.5rem;
            padding: 2.25rem;
            color: #fff;
            box-shadow: 0 18px 40px rgba(30, 58, 138, .22);
        }

        .hero-search {
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 1rem;
        }

        .hero-stat {
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: .9rem;
            text-align: center;
        }

        .section-title {
            font-weight: 700;
            letter-spacing: .1px;
        }

        .category-pill {
            border: 1px solid #dbe3f3;
            border-radius: 999px;
            background: #fff;
            color: #334155;
            font-weight: 600;
            font-size: .82rem;
            padding: .45rem .9rem;
            text-decoration: none;
            transition: .2s ease;
        }

        .category-pill:hover {
            border-color: var(--brand);
            color: var(--brand);
        }

        .mini-banner {
            background: linear-gradient(120deg, #eff6ff, #e0e7ff);
            border: 1px solid #dbeafe;
            border-radius: 1rem;
        }

        .vehicle-card {
            border: 0;
            border-radius: 1rem;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
            transition: .2s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .15);
        }

        .vehicle-thumb {
            height: 180px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            position: relative;
            overflow: hidden;
        }

        .vehicle-thumb img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .vehicle-thumb-fallback {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand);
        }

        .vehicle-thumb .carousel-control-prev,
        .vehicle-thumb .carousel-control-next {
            width: 14%;
        }

        .vehicle-thumb .carousel-control-prev-icon,
        .vehicle-thumb .carousel-control-next-icon {
            background-color: rgba(15, 23, 42, .45);
            border-radius: 999px;
            padding: .72rem;
            background-size: 58%;
        }

        .price-tag {
            background: #eef2ff;
            color: #3730a3;
            font-weight: 700;
            border-radius: .65rem;
            padding: .35rem .55rem;
            font-size: .88rem;
        }

        .trust-card {
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #e5eaf4;
            height: 100%;
        }

        .cta-box {
            background: linear-gradient(110deg, #0f172a, #1e3a8a);
            border-radius: 1.2rem;
            color: #fff;
        }

        .category-block {
            scroll-margin-top: 90px;
        }
    </style>
</head>
<body>
    <div class="top-strip py-2">
        <div class="container d-flex justify-content-between flex-wrap gap-2">
            <span><i class="bi bi-shield-check me-1"></i>Verified vehicles | Easy booking | Trusted support</span>
            <span><i class="bi bi-headset me-1"></i>Need help? +91 98765 43210</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg sticky-top border-bottom main-nav">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill text-primary me-1"></i> Faizi Vehicle Rental
            </a>

            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm px-3">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        <section class="hero-wrap mb-4 mb-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-light text-primary fw-semibold mb-3">E-commerce style vehicle marketplace</span>
                    <h1 class="display-5 fw-bold mb-3">Rent the right vehicle for every trip</h1>
                    <p class="text-white-50 fs-5 mb-4">Compare categories, browse top vehicles, and book in a few clicks. Perfect for city rides, family trips, and premium travel.</p>

                    <div class="hero-search p-3 p-md-4 mb-3">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Pickup city">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control form-control-lg">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-lg">
                                    <option selected>Vehicle type</option>
                                    <option>SUV</option>
                                    <option>Sedan</option>
                                    <option>Luxury</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <a href="#categories" class="btn btn-light btn-lg fw-semibold">Search</a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="#categories" class="btn btn-light btn-lg px-4">Shop by Category</a>
                        @auth
                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-light btn-lg">Start Booking</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Create Account</a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-stat p-3">
                                <h4 class="fw-bold mb-1">{{ $categories->count() }}</h4>
                                <small>Categories</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3">
                                <h4 class="fw-bold mb-1">{{ $categories->sum(fn($cat) => $cat->vehicles->count()) }}</h4>
                                <small>Available Vehicles</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3">
                                <h4 class="fw-bold mb-1">4.9★</h4>
                                <small>Customer Rating</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3">
                                <h4 class="fw-bold mb-1">24/7</h4>
                                <small>Support Team</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mini-banner p-3 p-md-4 mb-4 mb-lg-5 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h2 class="h5 fw-bold mb-1">Weekend Special Offers</h2>
                <p class="mb-0 text-secondary">Get up to 20% better deals on featured vehicles this week.</p>
            </div>
            <a href="#featured" class="btn btn-primary">View Featured Deals</a>
        </section>

        @if($categories->isNotEmpty())
            <section id="categories" class="mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <h2 class="section-title h3 mb-0">Shop by Category</h2>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <a class="category-pill" href="#category-{{ $category->id }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </section>

            @foreach($categories as $category)
                <section class="mb-5 category-block" id="category-{{ $category->id }}">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h3 class="h4 fw-bold mb-1">{{ $category->name }}</h3>
                            <p class="text-muted mb-0">{{ $category->description ?: 'Reliable and top rated options in this segment.' }}</p>
                        </div>
                        <span class="badge text-bg-primary">{{ $category->vehicles->count() }} listed</span>
                    </div>

                    <div class="row g-4">
                        @forelse($category->vehicles as $vehicle)
                            <div class="col-md-6 col-lg-3">
                                <article class="card vehicle-card">
                                    @php
                                        $gallery = collect($vehicle->images ?? [])->filter()->values();

                                        if (!empty($vehicle->thumbnail)) {
                                            $gallery = collect([$vehicle->thumbnail])->merge($gallery)->unique()->values();
                                        }

                                        $carouselId = 'vehicle-carousel-'.$category->id.'-'.$vehicle->id;
                                    @endphp

                                    @if ($gallery->isNotEmpty())
                                        <div id="{{ $carouselId }}" class="carousel slide vehicle-thumb" data-bs-ride="carousel">
                                            <div class="carousel-inner h-100">
                                                @foreach ($gallery as $image)
                                                    <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/'.$image) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if ($gallery->count() > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="vehicle-thumb vehicle-thumb-fallback">
                                            <i class="bi bi-car-front-fill fs-1"></i>
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-semibold mb-0">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                            @if($vehicle->is_featured)
                                                <span class="badge text-bg-warning">Hot</span>
                                            @endif
                                        </div>

                                        <p class="small text-secondary mb-3">{{ $vehicle->year }} • {{ $vehicle->fuel_type ?: 'Fuel N/A' }} • {{ $vehicle->transmission ?: 'Transmission N/A' }}</p>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="price-tag">₹{{ number_format((float)$vehicle->price_per_day, 0) }}/day</span>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('home.vehicles.show', $vehicle->id) }}" class="btn btn-outline-primary btn-sm">View</a>
                                                <a href="{{ route('bookings.quick', $vehicle->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-bag-check me-1"></i> Book
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border text-muted mb-0">No vehicles available right now in this category.</div>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        @endif

        @if($featuredVehicles->isNotEmpty())
            <section class="mb-5" id="featured">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title h3 mb-0">Featured Deals</h2>
                    <span class="text-muted small">Top picks for popular routes</span>
                </div>

                <div class="row g-4">
                    @foreach($featuredVehicles as $vehicle)
                        <div class="col-md-6 col-lg-4">
                            <article class="card vehicle-card">
                                @php
                                    $featuredGallery = collect($vehicle->images ?? [])->filter()->values();

                                    if (!empty($vehicle->thumbnail)) {
                                        $featuredGallery = collect([$vehicle->thumbnail])->merge($featuredGallery)->unique()->values();
                                    }

                                    $featuredCarouselId = 'featured-carousel-'.$vehicle->id;
                                @endphp

                                @if ($featuredGallery->isNotEmpty())
                                    <div id="{{ $featuredCarouselId }}" class="carousel slide vehicle-thumb" data-bs-ride="carousel">
                                        <div class="carousel-inner h-100">
                                            @foreach ($featuredGallery as $image)
                                                <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/'.$image) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                                </div>
                                            @endforeach
                                        </div>

                                        @if ($featuredGallery->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#{{ $featuredCarouselId }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#{{ $featuredCarouselId }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <div class="vehicle-thumb vehicle-thumb-fallback">
                                        <i class="bi bi-car-front-fill fs-1"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge text-bg-info">{{ $vehicle->category?->name ?: 'Popular' }}</span>
                                        <span class="text-warning"><i class="bi bi-star-fill"></i> 4.8</span>
                                    </div>
                                    <h5 class="fw-semibold mb-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                    <p class="text-secondary small mb-3">{{ $vehicle->year }} • {{ $vehicle->city ?: 'City N/A' }}, {{ $vehicle->state ?: 'State N/A' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary fs-5">₹{{ number_format((float)$vehicle->price_per_day, 0) }}/day</span>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('home.vehicles.show', $vehicle->id) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                            <a href="{{ route('bookings.quick', $vehicle->id) }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="mb-5">
            <h2 class="section-title h3 mb-3">Why customers choose us</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="trust-card p-4">
                        <i class="bi bi-patch-check-fill text-primary fs-3"></i>
                        <h3 class="h5 fw-bold mt-3">Verified Fleet</h3>
                        <p class="text-secondary mb-0">Every vehicle listing is reviewed for quality, safety, and maintenance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card p-4">
                        <i class="bi bi-cash-coin text-success fs-3"></i>
                        <h3 class="h5 fw-bold mt-3">Transparent Pricing</h3>
                        <p class="text-secondary mb-0">Clear daily rates with no hidden surprises during booking.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card p-4">
                        <i class="bi bi-lightning-charge-fill text-warning fs-3"></i>
                        <h3 class="h5 fw-bold mt-3">Fast Checkout</h3>
                        <p class="text-secondary mb-0">Simple booking flow designed to save your time and effort.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-box p-4 p-md-5 mb-2">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <h2 class="h3 fw-bold mb-2">Ready to book your next ride?</h2>
                    <p class="mb-0 text-white-50">From budget friendly cars to premium SUVs — choose what fits your journey.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @auth
                        <a href="{{ route('bookings.create') }}" class="btn btn-light btn-lg">Book a Vehicle</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>© {{ date('Y') }} Faizi Vehicle Rental. All rights reserved.</span>
            <span class="text-secondary">Professional rentals for every journey.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
