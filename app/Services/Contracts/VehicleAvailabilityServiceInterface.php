<?php

namespace App\Services\Contracts;

use App\Models\VehicleAvailability;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VehicleAvailabilityServiceInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): VehicleAvailability;

    public function create(array $data): VehicleAvailability;

    public function update(int $id, array $data): VehicleAvailability;

    public function delete(int $id): bool;
}
