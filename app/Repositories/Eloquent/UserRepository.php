<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->with(['profile', 'roles'])
            ->when(! empty($filters['q']), function ($query) use ($filters) {
                $keyword = trim((string) $filters['q']);

                $query->where(function ($inner) use ($keyword) {
                    $inner->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('phone', 'like', "%{$keyword}%");
                });
            })
            ->when(! empty($filters['role']), fn ($query) => $query->where('role', $filters['role']))
            ->when(! empty($filters['status']), fn ($query) => $query->where('status', $filters['status']))
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::onlyTrashed()
            ->with(['profile', 'roles'])
            ->when(! empty($filters['q']), function ($query) use ($filters) {
                $keyword = trim((string) $filters['q']);

                $query->where(function ($inner) use ($keyword) {
                    $inner->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('phone', 'like', "%{$keyword}%");
                });
            })
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id, bool $withTrashed = false): User
    {
        $query = User::query()->with(['profile', 'roles']);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->refresh();
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }

    public function restore(int $id): bool
    {
        return (bool) User::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(int $id): bool
    {
        return (bool) User::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function getAssignableRoles(): Collection
    {
        return Role::query()->orderBy('name')->get(['id', 'name']);
    }

    public function emailExists(string $email, ?int $ignoreId = null): bool
    {
        return User::withTrashed()
            ->where('email', $email)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists();
    }
}
