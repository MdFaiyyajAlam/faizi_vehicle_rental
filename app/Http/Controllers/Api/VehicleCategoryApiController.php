<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleCategoryRequest;
use App\Http\Requests\UpdateVehicleCategoryRequest;
use App\Services\Contracts\VehicleCategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleCategoryApiController extends Controller
{
    public function __construct(
        private readonly VehicleCategoryServiceInterface $vehicleCategoryService
    ) {
        $this->middleware('permission:view_categories')->only(['index', 'show', 'trashed']);
        $this->middleware('permission:create_categories')->only(['store']);
        $this->middleware('permission:edit_categories')->only(['update']);
        $this->middleware('permission:delete_categories')->only(['destroy', 'restore', 'forceDelete']);
    }

    public function index(Request $request): JsonResponse
    {
        $categories = $this->vehicleCategoryService->paginate((int) $request->integer('per_page', 10));

        return response()->json($categories);
    }

    public function trashed(Request $request): JsonResponse
    {
        $categories = $this->vehicleCategoryService->paginateTrashed((int) $request->integer('per_page', 10));

        return response()->json($categories);
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->vehicleCategoryService->findById($id, true);

        return response()->json($category);
    }

    public function store(StoreVehicleCategoryRequest $request): JsonResponse
    {
        $category = $this->vehicleCategoryService->create($request->validated());

        return response()->json($category, 201);
    }

    public function update(UpdateVehicleCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->vehicleCategoryService->update($id, $request->validated());

        return response()->json($category);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->vehicleCategoryService->delete($id);

        return response()->json(['message' => 'Vehicle category moved to trash.']);
    }

    public function restore(int $id): JsonResponse
    {
        $this->vehicleCategoryService->restore($id);

        return response()->json(['message' => 'Vehicle category restored successfully.']);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $this->vehicleCategoryService->forceDelete($id);

        return response()->json(['message' => 'Vehicle category permanently deleted.']);
    }
}
