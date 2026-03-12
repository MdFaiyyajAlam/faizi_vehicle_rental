<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Vehicle Availabilities</h2>
                <small class="text-muted">Manage day-wise vehicle availability and pricing</small>
            </div>
            @can('create_availabilities')
                <a href="{{ route('vehicle-availabilities.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Availability
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
                                <th class="ps-3">Vehicle</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Special Price</th>
                                <th>Slots</th>
                                <th class="text-end pe-3" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($availabilities as $availability)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark">
                                            {{ $availability->vehicle?->brand }} {{ $availability->vehicle?->model }}
                                        </div>
                                        <small class="text-muted">{{ $availability->vehicle?->registration_number }}</small>
                                    </td>
                                    <td>{{ optional($availability->date)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $availability->status === 'available' ? 'success' : ($availability->status === 'booked' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($availability->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $availability->special_price ? '₹'.number_format((float) $availability->special_price, 2) : '—' }}
                                    </td>
                                    <td>
                                        @if (!empty($availability->time_slots))
                                            <small>{{ implode(', ', $availability->time_slots) }}</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            @can('edit_availabilities')
                                                <a href="{{ route('vehicle-availabilities.edit', $availability->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endcan
                                            @can('delete_availabilities')
                                                <form method="POST" action="{{ route('vehicle-availabilities.destroy', $availability->id) }}" onsubmit="return confirm('Delete this availability record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-calendar2-check fs-3 text-muted d-block mb-2"></i>
                                        <h6 class="mb-1">No availability records found</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($availabilities->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $availabilities->links() }}</div>
        @endif
    </div>
</x-app-layout>
