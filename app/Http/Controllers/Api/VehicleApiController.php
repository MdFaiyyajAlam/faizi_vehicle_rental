<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Services\Contracts\VehicleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleApiController extends Controller
{
    public function __construct(
        private readonly VehicleServiceInterface $vehicleService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $vehicles = $this->vehicleService->paginate((int) $request->integer('per_page', 10));

        return response()->json($vehicles);
    }

    public function trashed(Request $request): JsonResponse
    {
        $vehicles = $this->vehicleService->paginateTrashed((int) $request->integer('per_page', 10));

        return response()->json($vehicles);
    }

    public function show(int $id): JsonResponse
    {
        $vehicle = $this->vehicleService->findById($id, true);

        return response()->json($vehicle);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = $this->vehicleService->create($request->validated());

        return response()->json($vehicle, 201);
    }

    public function update(UpdateVehicleRequest $request, int $id): JsonResponse
    {
        $vehicle = $this->vehicleService->update($id, $request->validated());

        return response()->json($vehicle);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->vehicleService->delete($id);

        return response()->json(['message' => 'Vehicle moved to trash.']);
    }

    public function restore(int $id): JsonResponse
    {
        $this->vehicleService->restore($id);

        return response()->json(['message' => 'Vehicle restored successfully.']);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $this->vehicleService->forceDelete($id);

        return response()->json(['message' => 'Vehicle permanently deleted.']);
    }
}
