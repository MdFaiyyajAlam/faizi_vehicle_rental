<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleCategoryRequest;
use App\Http\Requests\UpdateVehicleCategoryRequest;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleCategoryController extends Controller
{
    public function __construct(
        private readonly VehicleCategoryServiceInterface $vehicleCategoryService
    ) {
        $this->middleware('permission:view_categories')->only(['index', 'show', 'trashed']);
        $this->middleware('permission:create_categories')->only(['create', 'store']);
        $this->middleware('permission:edit_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_categories')->only(['destroy', 'restore', 'forceDelete']);
    }

    public function index(Request $request): View
    {
        $categories = $this->vehicleCategoryService->paginate((int) $request->integer('per_page', 10));

        return view('vehicle-categories.index', compact('categories'));
    }

    public function trashed(Request $request): View
    {
        $categories = $this->vehicleCategoryService->paginateTrashed((int) $request->integer('per_page', 10));

        return view('vehicle-categories.trashed', compact('categories'));
    }

    public function create(): View
    {
        return view('vehicle-categories.create');
    }

    public function store(StoreVehicleCategoryRequest $request): RedirectResponse
    {
        $this->vehicleCategoryService->create($request->validated());

        return redirect()
            ->route('vehicle-categories.index')
            ->with('status', 'Vehicle category created successfully.');
    }

    public function edit(int $id): View
    {
        $vehicleCategory = $this->vehicleCategoryService->findById($id);

        return view('vehicle-categories.edit', compact('vehicleCategory'));
    }

    public function show(int $id): View
    {
        $vehicleCategory = $this->vehicleCategoryService->findById($id);

        return view('vehicle-categories.show', compact('vehicleCategory'));
    }

    public function update(UpdateVehicleCategoryRequest $request, int $id): RedirectResponse
    {
        $this->vehicleCategoryService->update($id, $request->validated());

        return redirect()
            ->route('vehicle-categories.index')
            ->with('status', 'Vehicle category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->vehicleCategoryService->delete($id);

        return redirect()
            ->route('vehicle-categories.index')
            ->with('status', 'Vehicle category moved to trash.');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->vehicleCategoryService->restore($id);

        return redirect()
            ->route('vehicle-categories.trashed')
            ->with('status', 'Vehicle category restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $this->vehicleCategoryService->forceDelete($id);

        return redirect()
            ->route('vehicle-categories.trashed')
            ->with('status', 'Vehicle category permanently deleted.');
    }
}
