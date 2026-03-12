<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | Faizi Vehicle Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh; background: radial-gradient(circle at top right, #1d4ed8, #0f172a); font-family:'Inter','Segoe UI',sans-serif; }
        .auth-shell { min-height:100vh; }
        .auth-card { border:0; border-radius:1rem; box-shadow:0 18px 35px rgba(15,23,42,.2); }
        .benefit-chip { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:999px; padding:.34rem .75rem; font-size:.82rem; }
    </style>
</head>
<body>
    <div class="container auth-shell d-flex align-items-center py-4">
        <div class="row g-4 w-100 align-items-center">
            <div class="col-lg-6 text-white">
                <a href="{{ route('home') }}" class="text-white text-decoration-none fw-bold fs-4 d-inline-flex align-items-center mb-3">
                    <i class="bi bi-car-front-fill me-2"></i> Faizi Vehicle Rental
                </a>
                <h1 class="display-6 fw-bold">Create your account 🚀</h1>
                <p class="text-white-50 mb-3">Register karein aur turant premium vehicles browse + book karna start karein.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="benefit-chip">Quick Signup</span>
                    <span class="benefit-chip">Secure Access</span>
                    <span class="benefit-chip">Instant Booking</span>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h4 fw-bold mb-1">Register now</h2>
                        <p class="text-muted small mb-4">It takes less than a minute</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control form-control-lg @error('name') is-invalid @enderror" required autofocus autocomplete="name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required autocomplete="username">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input id="password" type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button class="btn btn-primary btn-lg w-100" type="submit">Create Account</button>

                            <p class="small text-muted mt-3 mb-0">Already registered? <a href="{{ route('login') }}" class="text-decoration-none">Log in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
