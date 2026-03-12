<?php

namespace App\Repositories\Contracts;

use App\Models\VehicleAvailability;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VehicleAvailabilityRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): VehicleAvailability;

    public function create(array $data): VehicleAvailability;

    public function update(VehicleAvailability $availability, array $data): VehicleAvailability;

    public function delete(VehicleAvailability $availability): bool;
}
