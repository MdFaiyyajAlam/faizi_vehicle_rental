<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Trashed Vehicles</h2>
                <small class="text-muted">Restore deleted vehicles or remove permanently</small>
            </div>

            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
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
                                <th>Registration</th>
                                <th>Deleted At</th>
                                <th class="text-end pe-3" style="width: 280px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="ps-3 fw-semibold text-dark">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                    <td class="text-muted">{{ $vehicle->registration_number }}</td>
                                    <td><span class="badge text-bg-warning">{{ optional($vehicle->deleted_at)->format('d M Y, h:i A') }}</span></td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <form method="POST" action="{{ route('vehicles.restore', $vehicle->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-arrow-counterclockwise me-1"></i> Restore</button>
                                            </form>
                                            <form method="POST" action="{{ route('vehicles.force-delete', $vehicle->id) }}" onsubmit="return confirm('Permanently delete this vehicle? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash3 me-1"></i> Delete Permanently</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-trash fs-3 text-muted d-block mb-2"></i>
                                        <h6 class="mb-1">Trash is empty</h6>
                                        <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-sm mt-2">Back to Vehicles</a>
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
