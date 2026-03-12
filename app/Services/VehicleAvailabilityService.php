<?php

namespace App\Services;

use App\Models\VehicleAvailability;
use App\Repositories\Contracts\VehicleAvailabilityRepositoryInterface;
use App\Services\Contracts\VehicleAvailabilityServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VehicleAvailabilityService implements VehicleAvailabilityServiceInterface
{
    public function __construct(
        private readonly VehicleAvailabilityRepositoryInterface $vehicleAvailabilityRepository
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->vehicleAvailabilityRepository->paginate($perPage);
    }

    public function findById(int $id): VehicleAvailability
    {
        return $this->vehicleAvailabilityRepository->findById($id);
    }

    public function create(array $data): VehicleAvailability
    {
        $payload = $this->normalizePayload($data);

        return $this->vehicleAvailabilityRepository->create($payload);
    }

    public function update(int $id, array $data): VehicleAvailability
    {
        $availability = $this->vehicleAvailabilityRepository->findById($id);
        $payload = $this->normalizePayload($data);

        return $this->vehicleAvailabilityRepository->update($availability, $payload);
    }

    public function delete(int $id): bool
    {
        $availability = $this->vehicleAvailabilityRepository->findById($id);

        return $this->vehicleAvailabilityRepository->delete($availability);
    }

    private function normalizePayload(array $data): array
    {
        if (array_key_exists('time_slots', $data)) {
            $data['time_slots'] = $this->normalizeTimeSlots($data['time_slots']);
        }

        return $data;
    }

    private function normalizeTimeSlots(mixed $timeSlots): array
    {
        if (is_array($timeSlots)) {
            return collect($timeSlots)
                ->map(fn ($slot) => is_string($slot) ? trim($slot) : '')
                ->filter()
                ->values()
                ->all();
        }

        if (! is_string($timeSlots) || trim($timeSlots) === '') {
            return [];
        }

        return collect(explode(',', $timeSlots))
            ->map(fn ($slot) => trim($slot))
            ->filter()
            ->values()
            ->all();
    }
}
