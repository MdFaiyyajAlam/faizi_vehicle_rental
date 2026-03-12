@php
    $user = $user ?? null;
    $profile = $user?->profile;
    $selectedRoles = old('spatie_roles', $user ? $user->roles->pluck('name')->all() : []);
    $selectedPreferences = old('preferences', $profile?->preferences ?? []);
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-semibold">Basic Account Info</h5></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    @foreach (['admin', 'vendor', 'customer', 'driver'] as $role)
                        <option value="{{ $role }}" {{ old('role', $user?->role ?? 'customer') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach (['active', 'inactive', 'suspended'] as $status)
                        <option value="{{ $status }}" {{ old('status', $user?->status ?? 'active') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Password {{ $user ? '' : '*' }}</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $user ? '' : 'required' }}>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password {{ $user ? '' : '*' }}</label>
                <input type="password" name="password_confirmation" class="form-control" {{ $user ? '' : 'required' }}>
            </div>
            <div class="col-md-6">
                <label class="form-label">Avatar</label>
                <input type="file" name="avatar" accept="image/*" class="form-control @error('avatar') is-invalid @enderror">
                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if($user?->avatar)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="avatar" class="rounded border" style="width:64px;height:64px;object-fit:cover;">
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">Documents (multiple)</label>
                <input type="file" name="documents[]" multiple class="form-control @error('documents') is-invalid @enderror @error('documents.*') is-invalid @enderror">
                @error('documents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @error('documents.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-semibold">Role & Preferences</h5></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Assign Spatie Roles</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($roles as $roleItem)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="spatie_roles[]" value="{{ $roleItem->name }}" id="role_{{ $roleItem->id }}"
                                {{ in_array($roleItem->name, $selectedRoles, true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $roleItem->id }}">{{ $roleItem->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Preferences (optional)</label>
                <input type="text" name="preferences[]" class="form-control mb-2" value="{{ $selectedPreferences[0] ?? '' }}" placeholder="e.g. email_notifications">
                <input type="text" name="preferences[]" class="form-control mb-2" value="{{ $selectedPreferences[1] ?? '' }}" placeholder="e.g. sms_alerts">
                <input type="text" name="preferences[]" class="form-control" value="{{ $selectedPreferences[2] ?? '' }}" placeholder="e.g. dark_mode">
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-semibold">Profile Details</h5></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Address Line 1</label>
                <input type="text" name="address_line1" value="{{ old('address_line1', $profile?->address_line1) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 2</label>
                <input type="text" name="address_line2" value="{{ old('address_line2', $profile?->address_line2) }}" class="form-control">
            </div>
            <div class="col-md-3"><label class="form-label">City</label><input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">State</label><input type="text" name="state" value="{{ old('state', $profile?->state) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Country</label><input type="text" name="country" value="{{ old('country', $profile?->country) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Postal Code</label><input type="text" name="postal_code" value="{{ old('postal_code', $profile?->postal_code) }}" class="form-control"></div>

            <div class="col-md-4"><label class="form-label">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($profile?->date_of_birth)->format('Y-m-d')) }}" class="form-control"></div>
            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select</option>
                    @foreach(['male', 'female', 'other'] as $gender)
                        <option value="{{ $gender }}" {{ old('gender', $profile?->gender) === $gender ? 'selected' : '' }}>{{ ucfirst($gender) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Emergency Contact</label><input type="text" name="emergency_contact" value="{{ old('emergency_contact', $profile?->emergency_contact) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Emergency Phone</label><input type="text" name="emergency_phone" value="{{ old('emergency_phone', $profile?->emergency_phone) }}" class="form-control"></div>

            <div class="col-12">
                <label class="form-label">Bio</label>
                <textarea name="bio" rows="3" class="form-control">{{ old('bio', $profile?->bio) }}</textarea>
            </div>
        </div>
    </div>
</div>
