<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="h4 mb-0 fw-bold text-dark">User Details</h2>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </x-slot>

    @php
        $profile = $user->profile;
    @endphp

    <div class="container-fluid px-0">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mx-auto rounded-circle border overflow-hidden d-flex align-items-center justify-content-center bg-light mb-3" style="width:96px;height:96px;">
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" alt="avatar" style="width:96px;height:96px;object-fit:cover;">
                            @else
                                <i class="bi bi-person fs-2 text-muted"></i>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <span class="badge text-bg-primary">{{ ucfirst($user->role) }}</span>
                            <span class="badge text-bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">{{ ucfirst($user->status) }}</span>
                        </div>
                        <small class="text-muted">Spatie Roles: {{ $user->roles->pluck('name')->implode(', ') ?: 'N/A' }}</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Account Info</strong></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><strong>Phone:</strong> {{ $user->phone ?: 'N/A' }}</div>
                            <div class="col-md-6"><strong>Email Verified:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y, h:i A') : 'No' }}</div>
                            <div class="col-md-6"><strong>Created:</strong> {{ $user->created_at?->format('d M Y, h:i A') }}</div>
                            <div class="col-md-6"><strong>Updated:</strong> {{ $user->updated_at?->format('d M Y, h:i A') }}</div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>Profile Info</strong></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><strong>DOB:</strong> {{ optional($profile?->date_of_birth)->format('d M Y') ?: 'N/A' }}</div>
                            <div class="col-md-6"><strong>Gender:</strong> {{ $profile?->gender ? ucfirst($profile->gender) : 'N/A' }}</div>
                            <div class="col-md-6"><strong>Emergency Contact:</strong> {{ $profile?->emergency_contact ?: 'N/A' }}</div>
                            <div class="col-md-6"><strong>Emergency Phone:</strong> {{ $profile?->emergency_phone ?: 'N/A' }}</div>
                            <div class="col-12"><strong>Address:</strong> {{ collect([$profile?->address_line1, $profile?->address_line2, $profile?->city, $profile?->state, $profile?->country, $profile?->postal_code])->filter()->implode(', ') ?: 'N/A' }}</div>
                            <div class="col-12"><strong>Bio:</strong> {{ $profile?->bio ?: 'N/A' }}</div>
                            <div class="col-12"><strong>Preferences:</strong> {{ collect($profile?->preferences ?? [])->filter()->implode(', ') ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><strong>Documents</strong></div>
                    <div class="card-body">
                        @php $docs = collect($profile?->documents ?? [])->filter(); @endphp
                        @if($docs->isEmpty())
                            <p class="text-muted mb-0">No documents uploaded.</p>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($docs as $doc)
                                    <a href="{{ asset('storage/'.$doc) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark me-1"></i> View Document {{ $loop->iteration }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
