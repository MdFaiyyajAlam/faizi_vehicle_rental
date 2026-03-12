<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleAvailabilityRequest;
use App\Http\Requests\UpdateVehicleAvailabilityRequest;
use App\Models\Vehicle;
use App\Services\Contracts\VehicleAvailabilityServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleAvailabilityController extends Controller
{
    public function __construct(
        private readonly VehicleAvailabilityServiceInterface $vehicleAvailabilityService
    ) {
        $this->middleware('permission:view_availabilities')->only(['index']);
        $this->middleware('permission:create_availabilities')->only(['create', 'store']);
        $this->middleware('permission:edit_availabilities')->only(['edit', 'update']);
        $this->middleware('permission:delete_availabilities')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $availabilities = $this->vehicleAvailabilityService->paginate((int) $request->integer('per_page', 10));

        return view('vehicle-availabilities.index', compact('availabilities'));
    }

    public function create(): View
    {
        $vehicles = Vehicle::query()
            ->select(['id', 'brand', 'model', 'registration_number'])
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        return view('vehicle-availabilities.create', compact('vehicles'));
    }

    public function store(StoreVehicleAvailabilityRequest $request): RedirectResponse
    {
        $this->vehicleAvailabilityService->create($request->validated());

        return redirect()
            ->route('vehicle-availabilities.index')
            ->with('status', 'Vehicle availability created successfully.');
    }

    public function edit(int $id): View
    {
        $availability = $this->vehicleAvailabilityService->findById($id);
        $vehicles = Vehicle::query()
            ->select(['id', 'brand', 'model', 'registration_number'])
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        return view('vehicle-availabilities.edit', compact('availability', 'vehicles'));
    }

    public function update(UpdateVehicleAvailabilityRequest $request, int $id): RedirectResponse
    {
        $this->vehicleAvailabilityService->update($id, $request->validated());

        return redirect()
            ->route('vehicle-availabilities.index')
            ->with('status', 'Vehicle availability updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->vehicleAvailabilityService->delete($id);

        return redirect()
            ->route('vehicle-availabilities.index')
            ->with('status', 'Vehicle availability deleted successfully.');
    }
}
