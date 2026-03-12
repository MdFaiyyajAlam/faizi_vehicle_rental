<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Trashed Users</h2>
                <small class="text-muted">Restore or permanently delete users</small>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Users</a>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        @if (session('status'))
            <div class="alert alert-success shadow-sm border-0"><i class="bi bi-check-circle me-1"></i> {{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('users.trashed') }}" class="row g-2">
                    <div class="col-md-10">
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Search trashed users...">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">User</th>
                                <th>Role</th>
                                <th>Deleted At</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ optional($user->deleted_at)->format('d M Y, h:i A') }}</td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <form method="POST" action="{{ route('users.restore', $user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                            </form>
                                            <form method="POST" action="{{ route('users.force-delete', $user->id) }}" onsubmit="return confirm('This action is permanent. Continue?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-5">Trash is empty.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($users->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $users->links() }}</div>
        @endif
    </div>
</x-app-layout>
