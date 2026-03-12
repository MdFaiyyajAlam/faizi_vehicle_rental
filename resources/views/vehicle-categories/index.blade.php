<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-0 fw-bold text-dark">Vehicle Categories</h2>
                <small class="text-muted">Manage category pricing, status and booking rules</small>
            </div>

            <div class="d-flex gap-2">
                @can('delete_categories')
                    <a href="{{ route('vehicle-categories.trashed') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-trash3 me-1"></i> Trash
                    </a>
                @endcan
                @can('create_categories')
                    <a href="{{ route('vehicle-categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Category
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

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Category</th>
                                <th>Pricing (₹)</th>
                                <th>Status</th>
                                <th class="text-end pe-3" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($category->image)
                                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="rounded border" style="width:40px;height:40px;object-fit:cover;">
                                            @else
                                                <span class="d-inline-flex align-items-center justify-content-center rounded border bg-light text-muted" style="width:40px;height:40px;">
                                                    <i class="bi bi-image"></i>
                                                </span>
                                            @endif

                                            <div>
                                                <div class="fw-semibold text-dark">{{ $category->name }}</div>
                                                <small class="text-muted">Slug: {{ $category->slug ?: '—' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><small class="text-muted">Hour:</small> <strong>{{ number_format((float) $category->base_price_per_hour, 2) }}</strong></div>
                                        <div><small class="text-muted">Day:</small> <strong>{{ number_format((float) $category->base_price_per_day, 2) }}</strong></div>
                                        <div><small class="text-muted">Week:</small> <strong>{{ number_format((float) $category->base_price_per_week, 2) }}</strong></div>
                                    </td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge text-bg-success">Active</span>
                                        @else
                                            <span class="badge text-bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('vehicle-categories.show', $category->id) }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('edit_categories')
                                                <a href="{{ route('vehicle-categories.edit', $category->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endcan
                                            @can('delete_categories')
                                                <form method="POST" action="{{ route('vehicle-categories.destroy', $category->id) }}" onsubmit="return confirm('Move this category to trash?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-inboxes fs-3 text-muted d-block mb-2"></i>
                                        <h6 class="mb-1">No categories found</h6>
                                        <p class="text-muted mb-3">Create your first vehicle category to get started.</p>
                                        @can('create_categories')
                                            <a href="{{ route('vehicle-categories.create') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i> Add Category
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $categories->links() }}
            </div>
        @endif
        </div>
</x-app-layout>
