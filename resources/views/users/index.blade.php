<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Users</h2>
                <small class="text-muted">Manage users, roles, status and profile data</small>
            </div>

            <div class="d-flex gap-2">
                @can('delete_users')
                    <a href="{{ route('users.trashed') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-trash3 me-1"></i> Trash
                    </a>
                @endcan
                @can('create_users')
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add User
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        @if (session('status'))
            <div class="alert alert-success shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('users.index') }}" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Search by name, email, phone">
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">All roles</option>
                            @foreach (['admin', 'vendor', 'customer', 'driver'] as $role)
                                <option value="{{ $role }}" {{ ($filters['role'] ?? '') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All status</option>
                            @foreach (['active', 'inactive', 'suspended'] as $status)
                                <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Filter</button>
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
                                <th>Status</th>
                                <th>Contact</th>
                                <th class="text-end pe-3" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-light border overflow-hidden d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                                                @if($user->avatar)
                                                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="avatar" style="width:42px;height:42px;object-fit:cover;">
                                                @else
                                                    <i class="bi bi-person text-muted"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">ID: #{{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ ucfirst($user->role) }}</div>
                                        <small class="text-muted">{{ $user->roles->pluck('name')->implode(', ') ?: '—' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $user->email }}</div>
                                        <small class="text-muted">{{ $user->phone ?: 'No phone' }}</small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
                                            @can('edit_users')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            @endcan
                                            @can('delete_users')
                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Move this user to trash?')">
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
                                    <td colspan="5" class="text-center py-5">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $users->links() }}</div>
        @endif
    </div>
</x-app-layout>
