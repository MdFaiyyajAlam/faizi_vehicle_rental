<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h2 class="h4 mb-0 fw-bold text-dark">{{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'User') }} Dashboard</h2>
            <span class="badge text-bg-primary px-3 py-2">Welcome, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2">Total Vehicles</p>
                        <h3 class="mb-0 fw-bold">128</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2">Active Bookings</p>
                        <h3 class="mb-0 fw-bold">34</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2">Pending Payments</p>
                        <h3 class="mb-0 fw-bold">9</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2">Customer Reviews</p>
                        <h3 class="mb-0 fw-bold">86</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="card-title mb-0 fw-semibold">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>New booking created</span><small class="text-muted">2 mins ago</small>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>Vehicle category updated</span><small class="text-muted">30 mins ago</small>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>Payment received</span><small class="text-muted">1 hour ago</small>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>Profile details changed</span><small class="text-muted">3 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="card-title mb-0 fw-semibold">Quick Actions</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        @can('create_categories')
                            <a href="{{ route('vehicle-categories.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add Vehicle Category
                            </a>
                        @endcan
                        @can('view_categories')
                            <a href="{{ route('vehicle-categories.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-list-ul me-1"></i> Manage Categories
                            </a>
                        @endcan
                        @can('view_vehicles')
                            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-truck me-1"></i> Manage Vehicles
                            </a>
                        @endcan
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-person me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
