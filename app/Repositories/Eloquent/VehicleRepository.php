<?php

namespace App\Repositories\Eloquent;

use App\Models\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Vehicle::query()
            ->with(['category:id,name', 'vendor:id,name'])
            ->latest('id')
            ->paginate($perPage);
    }

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator
    {
        return Vehicle::onlyTrashed()
            ->with(['category:id,name', 'vendor:id,name'])
            ->latest('id')
            ->paginate($perPage);
    }

    public function findById(int $id, bool $withTrashed = false): Vehicle
    {
        $query = Vehicle::query()->with(['category:id,name', 'vendor:id,name']);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->findOrFail($id);
    }

    public function create(array $data): Vehicle
    {
        return Vehicle::create($data);
    }

    public function update(Vehicle $vehicle, array $data): Vehicle
    {
        $vehicle->update($data);

        return $vehicle->refresh();
    }

    public function delete(Vehicle $vehicle): bool
    {
        return (bool) $vehicle->delete();
    }

    public function restore(int $id): bool
    {
        return (bool) Vehicle::onlyTrashed()
            ->findOrFail($id)
            ->restore();
    }

    public function forceDelete(int $id): bool
    {
        return (bool) Vehicle::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();
    }

    public function registrationExists(string $registrationNumber, ?int $ignoreId = null): bool
    {
        return Vehicle::withTrashed()
            ->where('registration_number', $registrationNumber)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists();
    }
}
