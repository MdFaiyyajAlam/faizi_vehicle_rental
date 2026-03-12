<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Bookings</h2>
                <small class="text-muted">Manage customer bookings and status lifecycle</small>
            </div>
            @can('create_bookings')
                <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Create Booking
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        @if (session('status'))
            <div class="alert alert-success shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Booking #</th>
                                <th>Vehicle</th>
                                <th>Customer</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th class="text-end pe-3" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="ps-3 fw-semibold">{{ $booking->booking_number }}</td>
                                    <td>{{ $booking->vehicle?->brand }} {{ $booking->vehicle?->model }}</td>
                                    <td>{{ $booking->customer?->name }}</td>
                                    <td>
                                        <small class="d-block">{{ optional($booking->start_date_time)->format('d M Y, h:i A') }}</small>
                                        <small class="text-muted">to {{ optional($booking->end_date_time)->format('d M Y, h:i A') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-{{ in_array($booking->booking_status, ['confirmed','completed']) ? 'success' : ($booking->booking_status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="d-block">Total: ₹{{ number_format((float) $booking->total_amount, 2) }}</small>
                                        <small class="text-muted">Due: ₹{{ number_format((float) $booking->due_amount, 2) }}</small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
                                            @can('edit_bookings')
                                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            @endcan
                                            @can('cancel_bookings')
                                                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" onsubmit="return confirm('Cancel this booking?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-x-circle"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-calendar-x fs-3 text-muted d-block mb-2"></i>
                                        <h6 class="mb-1">No bookings found</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($bookings->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $bookings->links() }}</div>
        @endif
    </div>
</x-app-layout>
