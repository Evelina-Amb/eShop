<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved.');
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);
        if (!$user) return $this->sendError('User not found.', 404);

        return $this->sendResponse(new UserResource($user), 'User found.');
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create($request->validated());
        return $this->sendResponse(new UserResource($user), 'User created.', 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated());
        if (!$user) return $this->sendError('User not found.', 404);

        return $this->sendResponse(new UserResource($user), 'User updated.');
    }

    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);
        if (!$deleted) return $this->sendError('User not found.', 404);

        return $this->sendResponse(null, 'User deleted.');
    }
}
