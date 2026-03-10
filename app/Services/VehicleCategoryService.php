<?php

namespace App\Services;

use App\Models\VehicleCategory;
use App\Repositories\Contracts\VehicleCategoryRepositoryInterface;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleCategoryService implements VehicleCategoryServiceInterface
{
    public function __construct(
        private readonly VehicleCategoryRepositoryInterface $vehicleCategoryRepository
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->vehicleCategoryRepository->paginate($perPage);
    }

    public function paginateTrashed(int $perPage = 10): LengthAwarePaginator
    {
        return $this->vehicleCategoryRepository->paginateTrashed($perPage);
    }

    public function getActive(): Collection
    {
        return $this->vehicleCategoryRepository->allActive();
    }

    public function findById(int $id, bool $withTrashed = false): VehicleCategory
    {
        return $this->vehicleCategoryRepository->findById($id, $withTrashed);
    }

    public function create(array $data): VehicleCategory
    {
        $payload = $this->normalizePayload($data);

        return $this->vehicleCategoryRepository->create($payload);
    }

    public function update(int $id, array $data): VehicleCategory
    {
        $vehicleCategory = $this->vehicleCategoryRepository->findById($id, true);
        $payload = $this->normalizePayload($data, $vehicleCategory->id, $vehicleCategory);

        return $this->vehicleCategoryRepository->update($vehicleCategory, $payload);
    }

    public function delete(int $id): bool
    {
        $vehicleCategory = $this->vehicleCategoryRepository->findById($id);

        return $this->vehicleCategoryRepository->delete($vehicleCategory);
    }

    public function restore(int $id): bool
    {
        return $this->vehicleCategoryRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->vehicleCategoryRepository->forceDelete($id);
    }

    private function normalizePayload(array $data, ?int $ignoreId = null, ?VehicleCategory $existingCategory = null): array
    {
        if (isset($data['image_file']) && $data['image_file'] instanceof UploadedFile) {
            if ($existingCategory?->image) {
                Storage::disk('public')->delete($existingCategory->image);
            }

            $data['image'] = $data['image_file']->store('vehicle-categories', 'public');
        }

        unset($data['image_file']);

        if (array_key_exists('features', $data)) {
            $data['features'] = $this->normalizeFeatures($data['features']);
        }

        if (empty($data['slug']) && ! empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (! empty($data['slug'])) {
            $baseSlug = Str::slug($data['slug']);
            $slug = $baseSlug;
            $counter = 1;

            while ($this->vehicleCategoryRepository->slugExists($slug, $ignoreId)) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $data['slug'] = $slug;
        }

        return $data;
    }

    private function normalizeFeatures(mixed $features): array
    {
        if (is_string($features)) {
            $features = explode(',', $features);
        }

        if (is_array($features) && count($features) === 1 && is_string($features[0])) {
            $features = explode(',', $features[0]);
        }

        if (! is_array($features)) {
            return [];
        }

        return collect($features)
            ->map(fn ($feature) => is_string($feature) ? trim($feature) : '')
            ->filter()
            ->values()
            ->all();
    }
}
