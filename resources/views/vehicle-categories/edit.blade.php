<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="h4 mb-0 fw-bold text-dark">Edit Vehicle Category</h2>
            <a href="{{ route('vehicle-categories.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-10">
                <form method="POST" action="{{ route('vehicle-categories.update', $vehicleCategory->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('vehicle-categories.partials.form', ['vehicleCategory' => $vehicleCategory])

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('vehicle-categories.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
