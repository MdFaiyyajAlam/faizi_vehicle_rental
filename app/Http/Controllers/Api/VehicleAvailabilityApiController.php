<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleAvailabilityRequest;
use App\Http\Requests\UpdateVehicleAvailabilityRequest;
use App\Services\Contracts\VehicleAvailabilityServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleAvailabilityApiController extends Controller
{
    public function __construct(
        private readonly VehicleAvailabilityServiceInterface $vehicleAvailabilityService
    ) {
        $this->middleware('permission:view_availabilities')->only(['index']);
        $this->middleware('permission:create_availabilities')->only(['store']);
        $this->middleware('permission:edit_availabilities')->only(['update']);
        $this->middleware('permission:delete_availabilities')->only(['destroy']);
    }

    public function index(Request $request): JsonResponse
    {
        $availabilities = $this->vehicleAvailabilityService->paginate((int) $request->integer('per_page', 10));

        return response()->json($availabilities);
    }

    public function store(StoreVehicleAvailabilityRequest $request): JsonResponse
    {
        $availability = $this->vehicleAvailabilityService->create($request->validated());

        return response()->json($availability, 201);
    }

    public function update(UpdateVehicleAvailabilityRequest $request, int $id): JsonResponse
    {
        $availability = $this->vehicleAvailabilityService->update($id, $request->validated());

        return response()->json($availability);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->vehicleAvailabilityService->delete($id);

        return response()->json(['message' => 'Vehicle availability deleted successfully.']);
    }
}
