<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Complete Payment</h2>
                <small class="text-muted">Booking #{{ $booking->booking_number }}</small>
            </div>
            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Booking
            </a>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        @if (session('status'))
            <div class="alert alert-success shadow-sm border-0">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-semibold">Payment Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('payments.store', $booking->id) }}" class="row g-3">
                            @csrf

                            <div class="col-md-6">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0.01" max="{{ (float) $booking->due_amount }}" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', (float) $booking->due_amount) }}" required>
                                @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                    <option value="">Select method</option>
                                    @foreach(['cash' => 'Cash', 'card' => 'Card', 'bank_transfer' => 'Bank Transfer', 'wallet' => 'Wallet', 'upi' => 'UPI'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('payment_method') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                                <select name="payment_type" class="form-select @error('payment_type') is-invalid @enderror" required>
                                    @foreach(['advance' => 'Advance', 'full' => 'Full', 'security_deposit' => 'Security Deposit', 'extra_charge' => 'Extra Charge'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('payment_type', 'full') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('payment_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Notes</label>
                                <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes') }}" placeholder="Optional notes">
                                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-credit-card me-1"></i> Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Booking Summary</h6></div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Vehicle:</strong> {{ $booking->vehicle?->brand }} {{ $booking->vehicle?->model }}</div>
                        <div class="mb-2"><strong>Customer:</strong> {{ $booking->customer?->name }}</div>
                        <div class="mb-2"><strong>Total:</strong> ₹{{ number_format((float) $booking->total_amount, 2) }}</div>
                        <div class="mb-2"><strong>Paid:</strong> ₹{{ number_format((float) $booking->paid_amount, 2) }}</div>
                        <div class="mb-2"><strong>Due:</strong> <span class="text-danger fw-semibold">₹{{ number_format((float) $booking->due_amount, 2) }}</span></div>
                        <hr>
                        <small class="text-muted">After booking creation, payment is required to confirm and proceed.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
