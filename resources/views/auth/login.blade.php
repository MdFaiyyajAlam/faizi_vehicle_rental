<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Faizi Vehicle Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh; background: radial-gradient(circle at top right, #2563eb, #0f172a); font-family:'Inter','Segoe UI',sans-serif; }
        .auth-shell { min-height:100vh; }
        .auth-card { border:0; border-radius:1rem; box-shadow:0 18px 35px rgba(15,23,42,.2); }
        .brand-badge { background:#e0e7ff; color:#3730a3; font-weight:600; border-radius:999px; padding:.3rem .7rem; font-size:.82rem; }
    </style>
</head>
<body>
    <div class="container auth-shell d-flex align-items-center py-4">
        <div class="row g-4 w-100 align-items-center">
            <div class="col-lg-6 text-white">
                <a href="{{ route('home') }}" class="text-white text-decoration-none fw-bold fs-4 d-inline-flex align-items-center mb-3">
                    <i class="bi bi-car-front-fill me-2"></i> Faizi Vehicle Rental
                </a>
                <h1 class="display-6 fw-bold">Welcome back 👋</h1>
                <p class="text-white-50 mb-3">Login karke apne bookings, favorite vehicles aur dashboard access karein.</p>
                <span class="brand-badge"><i class="bi bi-shield-check me-1"></i>Secure Sign-in</span>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h4 fw-bold mb-1">Log in to your account</h2>
                        <p class="text-muted small mb-4">Continue your rental journey</p>

                        <x-auth-session-status class="mb-3" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required autofocus autocomplete="username">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="current-password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
                                @endif
                            </div>

                            <button class="btn btn-primary btn-lg w-100" type="submit">Log in</button>

                            <p class="small text-muted mt-3 mb-0">New user? <a href="{{ route('register') }}" class="text-decoration-none">Create account</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
