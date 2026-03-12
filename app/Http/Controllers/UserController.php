<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
        $this->middleware('permission:view_users')->only(['index', 'show', 'trashed']);
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:edit_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only(['destroy', 'restore', 'forceDelete']);
    }

    public function index(Request $request): View
    {
        $filters = [
            'q' => $request->string('q')->toString(),
            'role' => $request->string('role')->toString(),
            'status' => $request->string('status')->toString(),
        ];

        $users = $this->userService->paginate($filters, (int) $request->integer('per_page', 10));

        return view('users.index', [
            'users' => $users,
            'filters' => $filters,
        ]);
    }

    public function trashed(Request $request): View
    {
        $filters = ['q' => $request->string('q')->toString()];
        $users = $this->userService->paginateTrashed($filters, (int) $request->integer('per_page', 10));

        return view('users.trashed', compact('users', 'filters'));
    }

    public function create(): View
    {
        $roles = $this->userService->getAssignableRoles();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }

    public function show(int $id): View
    {
        $user = $this->userService->findById($id, true);

        return view('users.show', compact('user'));
    }

    public function edit(int $id): View
    {
        $user = $this->userService->findById($id, true);
        $roles = $this->userService->getAssignableRoles();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $this->userService->update($id, $request->validated());

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->userService->delete($id);

        return redirect()->route('users.index')->with('status', 'User moved to trash.');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->userService->restore($id);

        return redirect()->route('users.trashed')->with('status', 'User restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $this->userService->forceDelete($id);

        return redirect()->route('users.trashed')->with('status', 'User permanently deleted.');
    }
}
