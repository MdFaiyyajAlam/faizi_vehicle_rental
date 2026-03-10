<?php

namespace App\Services\Contracts;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VehicleServiceInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id, bool $withTrashed = false): Vehicle;

    public function create(array $data): Vehicle;

    public function update(int $id, array $data): Vehicle;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;
}
