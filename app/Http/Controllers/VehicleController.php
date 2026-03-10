<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\User;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use App\Services\Contracts\VehicleServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleServiceInterface $vehicleService,
        private readonly VehicleCategoryServiceInterface $vehicleCategoryService,
    ) {
    }

    public function index(Request $request): View
    {
        $vehicles = $this->vehicleService->paginate((int) $request->integer('per_page', 10));

        return view('vehicles.index', compact('vehicles'));
    }

    public function trashed(Request $request): View
    {
        $vehicles = $this->vehicleService->paginateTrashed((int) $request->integer('per_page', 10));

        return view('vehicles.trashed', compact('vehicles'));
    }

    public function create(): View
    {
        $categories = $this->vehicleCategoryService->getActive();
        $vendors = $this->getVendors();

        return view('vehicles.create', compact('categories', 'vendors'));
    }

    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        $this->vehicleService->create($request->validated());

        return redirect()
            ->route('vehicles.index')
            ->with('status', 'Vehicle created successfully.');
    }

    public function show(int $id): View
    {
        $vehicle = $this->vehicleService->findById($id, true);

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(int $id): View
    {
        $vehicle = $this->vehicleService->findById($id, true);
        $categories = $this->vehicleCategoryService->getActive();
        $vendors = $this->getVendors();

        return view('vehicles.edit', compact('vehicle', 'categories', 'vendors'));
    }

    public function update(UpdateVehicleRequest $request, int $id): RedirectResponse
    {
        $this->vehicleService->update($id, $request->validated());

        return redirect()
            ->route('vehicles.index')
            ->with('status', 'Vehicle updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->vehicleService->delete($id);

        return redirect()
            ->route('vehicles.index')
            ->with('status', 'Vehicle moved to trash.');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->vehicleService->restore($id);

        return redirect()
            ->route('vehicles.trashed')
            ->with('status', 'Vehicle restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $this->vehicleService->forceDelete($id);

        return redirect()
            ->route('vehicles.trashed')
            ->with('status', 'Vehicle permanently deleted.');
    }

    private function getVendors(): Collection
    {
        return User::query()
            ->select(['id', 'name'])
            ->where('role', 'vendor')
            ->orderBy('name')
            ->get();
    }
}
