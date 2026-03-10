<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleCategory;
use App\Repositories\Contracts\VehicleCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class VehicleCategoryRepository implements VehicleCategoryRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return VehicleCategory::query()
            ->latest('id')
            ->paginate($perPage);
    }

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator
    {
        return VehicleCategory::onlyTrashed()
            ->latest('id')
            ->paginate($perPage);
    }

    public function allActive(): Collection
    {
        return VehicleCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function findById(int $id, bool $withTrashed = false): VehicleCategory
    {
        $query = VehicleCategory::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->findOrFail($id);
    }

    public function create(array $data): VehicleCategory
    {
        return VehicleCategory::create($data);
    }

    public function update(VehicleCategory $vehicleCategory, array $data): VehicleCategory
    {
        $vehicleCategory->update($data);

        return $vehicleCategory->refresh();
    }

    public function delete(VehicleCategory $vehicleCategory): bool
    {
        return (bool) $vehicleCategory->delete();
    }

    public function restore(int $id): bool
    {
        return (bool) VehicleCategory::onlyTrashed()
            ->findOrFail($id)
            ->restore();
    }

    public function forceDelete(int $id): bool
    {
        return (bool) VehicleCategory::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return VehicleCategory::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists();
    }
}
