<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface UserRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id, bool $withTrashed = false): User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function delete(User $user): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function getAssignableRoles(): \Illuminate\Support\Collection;

    public function emailExists(string $email, ?int $ignoreId = null): bool;
}
