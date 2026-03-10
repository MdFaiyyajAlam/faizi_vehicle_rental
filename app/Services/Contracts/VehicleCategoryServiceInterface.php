<?php

namespace App\Services\Contracts;

use App\Models\VehicleCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface VehicleCategoryServiceInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator;

    public function getActive(): Collection;

    public function findById(int $id, bool $withTrashed = false): VehicleCategory;

    public function create(array $data): VehicleCategory;

    public function update(int $id, array $data): VehicleCategory;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;
}
