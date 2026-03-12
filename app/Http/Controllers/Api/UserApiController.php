<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
        $this->middleware('permission:view_users')->only(['index', 'show', 'trashed']);
        $this->middleware('permission:create_users')->only(['store']);
        $this->middleware('permission:edit_users')->only(['update']);
        $this->middleware('permission:delete_users')->only(['destroy', 'restore', 'forceDelete']);
    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'q' => $request->string('q')->toString(),
            'role' => $request->string('role')->toString(),
            'status' => $request->string('status')->toString(),
        ];

        $users = $this->userService->paginate($filters, (int) $request->integer('per_page', 10));

        return response()->json($users);
    }

    public function trashed(Request $request): JsonResponse
    {
        $filters = ['q' => $request->string('q')->toString()];
        $users = $this->userService->paginateTrashed($filters, (int) $request->integer('per_page', 10));

        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findById($id, true);

        return response()->json($user);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return response()->json($user, 201);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->update($id, $request->validated());

        return response()->json($user);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return response()->json(['message' => 'User moved to trash.']);
    }

    public function restore(int $id): JsonResponse
    {
        $this->userService->restore($id);

        return response()->json(['message' => 'User restored successfully.']);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $this->userService->forceDelete($id);

        return response()->json(['message' => 'User permanently deleted.']);
    }
}
