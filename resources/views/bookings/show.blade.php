<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Booking Details</h2>
                <small class="text-muted">{{ $booking->booking_number }}</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                @can('edit_bookings')
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Booking Info</h6></div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Vehicle:</strong> {{ $booking->vehicle?->brand }} {{ $booking->vehicle?->model }}</div>
                        <div class="mb-2"><strong>Customer:</strong> {{ $booking->customer?->name }}</div>
                        <div class="mb-2"><strong>Vendor:</strong> {{ $booking->vendor?->name }}</div>
                        <div class="mb-2"><strong>Driver:</strong> {{ $booking->driver?->name ?: '—' }}</div>
                        <div class="mb-2"><strong>Type:</strong> {{ ucfirst($booking->booking_type) }}</div>
                        <div class="mb-2"><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}</div>
                        <div class="mb-2"><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-semibold">Amount Summary</h6></div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Base:</strong> ₹{{ number_format((float) $booking->base_price, 2) }}</div>
                        <div class="mb-2"><strong>Extra:</strong> ₹{{ number_format((float) $booking->extra_charges, 2) }}</div>
                        <div class="mb-2"><strong>Tax:</strong> ₹{{ number_format((float) $booking->tax_amount, 2) }}</div>
                        <div class="mb-2"><strong>Discount:</strong> ₹{{ number_format((float) $booking->discount_amount, 2) }}</div>
                        <div class="mb-2"><strong>Deposit:</strong> ₹{{ number_format((float) $booking->security_deposit, 2) }}</div>
                        <hr>
                        <div class="mb-2"><strong>Total:</strong> ₹{{ number_format((float) $booking->total_amount, 2) }}</div>
                        <div class="mb-2"><strong>Paid:</strong> ₹{{ number_format((float) $booking->paid_amount, 2) }}</div>
                        <div class="mb-2"><strong>Due:</strong> ₹{{ number_format((float) $booking->due_amount, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Payments</h6>
                        @if((float)$booking->due_amount > 0)
                            <a href="{{ route('payments.create', $booking->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-credit-card me-1"></i> Pay Due Amount
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($booking->payments->isEmpty())
                            <p class="text-muted mb-0">No payments recorded yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Txn ID</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Paid At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking->payments as $payment)
                                            <tr>
                                                <td><small>{{ $payment->transaction_id }}</small></td>
                                                <td>₹{{ number_format((float)$payment->amount, 2) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                                <td><span class="badge text-bg-success">{{ ucfirst($payment->status) }}</span></td>
                                                <td>{{ optional($payment->paid_at)->format('d M Y, h:i A') ?: '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
