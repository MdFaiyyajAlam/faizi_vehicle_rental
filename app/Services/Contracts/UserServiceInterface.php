<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id, bool $withTrashed = false): User;

    public function create(array $data): User;

    public function update(int $id, array $data): User;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function getAssignableRoles(): Collection;
}
