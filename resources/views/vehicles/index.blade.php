<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Vehicles</h2>
                <small class="text-muted">Manage vendor vehicles, pricing and status</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('vehicles.trashed') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-trash3 me-1"></i> Trash
                </a>
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Vehicle
                </a>
            </div>
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
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Pricing (₹)</th>
                                <th>Status</th>
                                <th class="text-end pe-3" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</div>
                                        <small class="text-muted">Reg: {{ $vehicle->registration_number }}</small>
                                    </td>
                                    <td>{{ $vehicle->vendor?->name ?: '—' }}</td>
                                    <td>{{ $vehicle->category?->name ?: '—' }}</td>
                                    <td>
                                        <div><small class="text-muted">Hour:</small> <strong>{{ number_format((float) $vehicle->price_per_hour, 2) }}</strong></div>
                                        <div><small class="text-muted">Day:</small> <strong>{{ number_format((float) $vehicle->price_per_day, 2) }}</strong></div>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-{{ $vehicle->status === 'available' ? 'success' : ($vehicle->status === 'maintenance' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle->id) }}" onsubmit="return confirm('Move this vehicle to trash?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-truck fs-3 text-muted d-block mb-2"></i>
                                        <h6 class="mb-1">No vehicles found</h6>
                                        <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm mt-2">Add Vehicle</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($vehicles->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $vehicles->links() }}</div>
        @endif
    </div>
</x-app-layout>
