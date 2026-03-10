<?php

namespace App\Repositories\Contracts;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VehicleRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id, bool $withTrashed = false): Vehicle;

    public function create(array $data): Vehicle;

    public function update(Vehicle $vehicle, array $data): Vehicle;

    public function delete(Vehicle $vehicle): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function registrationExists(string $registrationNumber, ?int $ignoreId = null): bool;
}
