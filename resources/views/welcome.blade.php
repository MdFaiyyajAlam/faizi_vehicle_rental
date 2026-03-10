<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faizi Vehicle Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            color: #fff;
            border-radius: 1rem;
            overflow: hidden;
        }

        .feature-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
            height: 100%;
        }

        .stat-box {
            background: #fff;
            border-radius: .8rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-car-front-fill text-primary me-1"></i> Faizi Vehicle Rental
            </a>

            <div class="ms-auto d-flex gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <section class="hero p-4 p-md-5 mb-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-3">Premium Car Rental Service in Your City</h1>
                    <p class="lead mb-4">Faizi Vehicle Rental provides affordable, reliable and premium vehicles for daily, weekly, and monthly booking.</p>
                    <div class="d-flex flex-wrap gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg">Book Now</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Create Account</a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-box p-3 text-dark text-center">
                                <h3 class="fw-bold mb-0">500+</h3>
                                <small>Happy Customers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box p-3 text-dark text-center">
                                <h3 class="fw-bold mb-0">120+</h3>
                                <small>Vehicles</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box p-3 text-dark text-center">
                                <h3 class="fw-bold mb-0">24/7</h3>
                                <small>Support</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box p-3 text-dark text-center">
                                <h3 class="fw-bold mb-0">4.9★</h3>
                                <small>Ratings</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Why Choose Faizi Vehicle Rental?</h2>
                <p class="text-muted">Professional service with transparent pricing and clean vehicles.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="bi bi-shield-check text-primary fs-2 mb-3"></i>
                        <h5 class="fw-semibold">Trusted & Secure</h5>
                        <p class="text-muted mb-0">Verified vehicles and secure booking process for complete peace of mind.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="bi bi-cash-coin text-primary fs-2 mb-3"></i>
                        <h5 class="fw-semibold">Affordable Pricing</h5>
                        <p class="text-muted mb-0">Get best rates for all vehicle categories without hidden charges.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="bi bi-speedometer2 text-primary fs-2 mb-3"></i>
                        <h5 class="fw-semibold">Fast Booking</h5>
                        <p class="text-muted mb-0">Simple and quick online booking with instant confirmation.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>© {{ date('Y') }} Faizi Vehicle Rental. All rights reserved.</span>
            <span class="text-secondary">Drive Smart. Drive Safe.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
