<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use App\Services\Contracts\VehicleServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VehicleService implements VehicleServiceInterface
{
    public function __construct(
        private readonly VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->vehicleRepository->paginate($perPage);
    }

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator
    {
        return $this->vehicleRepository->paginateTrashed($perPage);
    }

    public function findById(int $id, bool $withTrashed = false): Vehicle
    {
        return $this->vehicleRepository->findById($id, $withTrashed);
    }

    public function create(array $data): Vehicle
    {
        return $this->vehicleRepository->create($this->normalizePayload($data));
    }

    public function update(int $id, array $data): Vehicle
    {
        $vehicle = $this->vehicleRepository->findById($id, true);

        return $this->vehicleRepository->update($vehicle, $this->normalizePayload($data, $vehicle));
    }

    public function delete(int $id): bool
    {
        $vehicle = $this->vehicleRepository->findById($id);

        return $this->vehicleRepository->delete($vehicle);
    }

    public function restore(int $id): bool
    {
        return $this->vehicleRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->vehicleRepository->forceDelete($id);
    }

    private function normalizePayload(array $data, ?Vehicle $vehicle = null): array
    {
        $registrationNumber = strtoupper(trim((string) ($data['registration_number'] ?? '')));
        $ignoreId = $vehicle?->id;

        if ($registrationNumber !== '') {
            while ($this->vehicleRepository->registrationExists($registrationNumber, $ignoreId)) {
                $registrationNumber = $registrationNumber.'-'.Str::upper(Str::random(2));
            }

            $data['registration_number'] = $registrationNumber;
        }

        if (array_key_exists('features', $data)) {
            $data['features'] = $this->normalizeArrayField($data['features']);
        }

        if (array_key_exists('images', $data)) {
            if (is_array($data['images']) && collect($data['images'])->contains(fn ($image) => $image instanceof UploadedFile)) {
                if ($vehicle?->images) {
                    foreach ($vehicle->images as $existingImage) {
                        if (is_string($existingImage) && $existingImage !== '') {
                            Storage::disk('public')->delete($existingImage);
                        }
                    }
                }

                $data['images'] = collect($data['images'])
                    ->filter(fn ($image) => $image instanceof UploadedFile)
                    ->map(fn (UploadedFile $image) => $image->store('vehicles/images', 'public'))
                    ->values()
                    ->all();
            } else {
                $data['images'] = $this->normalizeArrayField($data['images']);
            }
        }

        if (array_key_exists('thumbnail', $data) && $data['thumbnail'] instanceof UploadedFile) {
            if (is_string($vehicle?->thumbnail) && $vehicle->thumbnail !== '') {
                Storage::disk('public')->delete($vehicle->thumbnail);
            }

            $data['thumbnail'] = $data['thumbnail']->store('vehicles/thumbnails', 'public');
        } elseif (array_key_exists('thumbnail', $data) && ! is_string($data['thumbnail'])) {
            unset($data['thumbnail']);
        }

        if (array_key_exists('documents', $data)) {
            $data['documents'] = $this->normalizeArrayField($data['documents']);
        }

        if (array_key_exists('location_coordinates', $data)) {
            $coordinates = $this->normalizeCoordinates($data['location_coordinates']);
            $data['location_coordinates'] = $coordinates ?: null;
        }

        return $data;
    }

    private function normalizeArrayField(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => is_string($item) ? trim($item) : '')
                ->filter()
                ->values()
                ->all();
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return collect($decoded)
                ->map(fn ($item) => is_string($item) ? trim($item) : '')
                ->filter()
                ->values()
                ->all();
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeCoordinates(mixed $value): array
    {
        if (is_array($value)) {
            return [
                'lat' => isset($value['lat']) ? (float) $value['lat'] : null,
                'lng' => isset($value['lng']) ? (float) $value['lng'] : null,
            ];
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return [
                'lat' => isset($decoded['lat']) ? (float) $decoded['lat'] : null,
                'lng' => isset($decoded['lng']) ? (float) $decoded['lng'] : null,
            ];
        }

        $parts = array_map('trim', explode(',', $value));

        if (count($parts) !== 2) {
            return [];
        }

        return [
            'lat' => (float) $parts[0],
            'lng' => (float) $parts[1],
        ];
    }
}
