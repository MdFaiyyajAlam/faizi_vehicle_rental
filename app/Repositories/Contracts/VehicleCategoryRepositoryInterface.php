<?php

namespace App\Repositories\Contracts;

use App\Models\VehicleCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface VehicleCategoryRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator;

    public function allActive(): Collection;

    public function findById(int $id, bool $withTrashed = false): VehicleCategory;

    public function create(array $data): VehicleCategory;

    public function update(VehicleCategory $vehicleCategory, array $data): VehicleCategory;

    public function delete(VehicleCategory $vehicleCategory): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function slugExists(string $slug, ?int $ignoreId = null): bool;
}
