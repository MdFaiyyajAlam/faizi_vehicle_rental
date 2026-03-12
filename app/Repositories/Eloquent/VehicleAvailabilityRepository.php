<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleAvailability;
use App\Repositories\Contracts\VehicleAvailabilityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VehicleAvailabilityRepository implements VehicleAvailabilityRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return VehicleAvailability::query()
            ->with(['vehicle:id,brand,model,registration_number'])
            ->latest('date')
            ->paginate($perPage);
    }

    public function findById(int $id): VehicleAvailability
    {
        return VehicleAvailability::query()
            ->with(['vehicle:id,brand,model,registration_number'])
            ->findOrFail($id);
    }

    public function create(array $data): VehicleAvailability
    {
        return VehicleAvailability::create($data);
    }

    public function update(VehicleAvailability $availability, array $data): VehicleAvailability
    {
        $availability->update($data);

        return $availability->refresh();
    }

    public function delete(VehicleAvailability $availability): bool
    {
        return (bool) $availability->delete();
    }
}
