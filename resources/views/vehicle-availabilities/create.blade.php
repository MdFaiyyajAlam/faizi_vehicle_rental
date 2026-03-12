<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="h4 mb-0 fw-bold text-dark">Create Vehicle Availability</h2>
            <a href="{{ route('vehicle-availabilities.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-10">
                <form method="POST" action="{{ route('vehicle-availabilities.store') }}">
                    @csrf
                    @include('vehicle-availabilities.partials.form')

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('vehicle-availabilities.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-1"></i> Save Availability
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
