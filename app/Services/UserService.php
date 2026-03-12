<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->paginate($filters, $perPage);
    }

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->paginateTrashed($filters, $perPage);
    }

    public function findById(int $id, bool $withTrashed = false): User
    {
        return $this->userRepository->findById($id, $withTrashed);
    }

    public function create(array $data): User
    {
        $roles = $data['spatie_roles'] ?? [];
        $payload = $this->normalizePayload($data);
        $profilePayload = $this->extractProfilePayload($data);

        $user = $this->userRepository->create($payload);
        $this->syncProfile($user, $profilePayload);
        $this->syncRoles($user, $roles);

        return $this->userRepository->findById($user->id);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->userRepository->findById($id, true);
        $roles = $data['spatie_roles'] ?? [];
        $payload = $this->normalizePayload($data, $user);
        $profilePayload = $this->extractProfilePayload($data, $user);

        $this->userRepository->update($user, $payload);
        $this->syncProfile($user, $profilePayload);
        $this->syncRoles($user, $roles);

        return $this->userRepository->findById($user->id, true);
    }

    public function delete(int $id): bool
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->delete($user);
    }

    public function restore(int $id): bool
    {
        return $this->userRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $user = $this->userRepository->findById($id, true);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $documents = $user->profile?->documents ?? [];
        foreach ($documents as $doc) {
            if (is_string($doc) && $doc !== '') {
                Storage::disk('public')->delete($doc);
            }
        }

        return $this->userRepository->forceDelete($id);
    }

    public function getAssignableRoles(): Collection
    {
        return $this->userRepository->getAssignableRoles();
    }

    private function normalizePayload(array $data, ?User $user = null): array
    {
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            if ($user?->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $data['avatar']->store('users/avatars', 'public');
        } elseif (array_key_exists('avatar', $data) && ! is_string($data['avatar'])) {
            unset($data['avatar']);
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make((string) $data['password']);
        } else {
            unset($data['password']);
        }

        $data['email_verified_at'] = isset($data['status']) && $data['status'] === 'active' ? now() : null;

        unset($data['spatie_roles']);

        return collect($data)
            ->except([
                'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code',
                'date_of_birth', 'gender', 'emergency_contact', 'emergency_phone', 'bio',
                'documents', 'preferences',
            ])
            ->toArray();
    }

    private function extractProfilePayload(array $data, ?User $user = null): array
    {
        $documents = [];

        if (! empty($data['documents']) && is_array($data['documents'])) {
            if ($user?->profile?->documents) {
                foreach ($user->profile->documents as $doc) {
                    if (is_string($doc) && $doc !== '') {
                        Storage::disk('public')->delete($doc);
                    }
                }
            }

            $documents = collect($data['documents'])
                ->filter(fn ($file) => $file instanceof UploadedFile)
                ->map(fn (UploadedFile $file) => $file->store('users/documents', 'public'))
                ->values()
                ->all();
        } elseif ($user?->profile?->documents) {
            $documents = $user->profile->documents;
        }

        return [
            'address_line1' => $data['address_line1'] ?? null,
            'address_line2' => $data['address_line2'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'emergency_phone' => $data['emergency_phone'] ?? null,
            'bio' => $data['bio'] ?? null,
            'documents' => $documents,
            'preferences' => isset($data['preferences']) && is_array($data['preferences'])
                ? collect($data['preferences'])->filter()->values()->all()
                : ($user?->profile?->preferences ?? []),
        ];
    }

    private function syncProfile(User $user, array $profilePayload): void
    {
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profilePayload
        );
    }

    private function syncRoles(User $user, array $roles): void
    {
        $roles = collect($roles)->filter()->values();

        if ($roles->isEmpty()) {
            $roles = collect([$user->role]);
        }

        $user->syncRoles($roles->all());
    }
}
