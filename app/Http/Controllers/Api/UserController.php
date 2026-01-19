<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\BaseCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
/**
 * @OA\Get(
 *   path="/api/users",
 *   summary="Get all users",
 *   tags={"Users"},
 *   @OA\Response(response=200, description="Users retrieved")
 * )
 */
    public function index()
    {
        $users = $this->userService->getAll();
        return $this->sendResponse(new BaseCollection($users, UserResource::class), 'Users retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/users/{id}",
 *   summary="Get single user",
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User found"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
    public function show($id)
    {
        $user = $this->userService->getById($id);
        if (!$user) return $this->sendError('User not found.', 404);

        return $this->sendResponse(new UserResource($user), 'User found.');
    }
/**
 * @OA\Post(
 *   path="/api/users",
 *   summary="Create user",
 *   tags={"Users"},
 *   @OA\Response(response=201, description="User created"),
 *   @OA\Response(response=400, description="Invalid input")
 * )
 */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create($request->validated());
        return $this->sendResponse(new UserResource($user), 'User created.', 201);
    }
/**
 * @OA\Put(
 *   path="/api/users/{id}",
 *   summary="Update user",
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User updated"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated());
        if (!$user) return $this->sendError('User not found.', 404);

        return $this->sendResponse(new UserResource($user), 'User updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/users/{id}",
 *   summary="Delete user",
 *   tags={"Users"},
 *   @OA\Response(response=200, description="User deleted"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);
        if (!$deleted) return $this->sendError('User not found.', 404);

        return $this->sendResponse(null, 'User deleted.');
    }
/**
 * @OA\Post(
 *   path="/api/users/{id}/ban",
 *   summary="Ban user",
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User banned"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
    public function ban(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        return $this->sendError('User not found.', 404);
    }

    $user->update([
        'is_banned' => true,
        'ban_reason' => $request->reason ?? 'No reason provided',
        'banned_at' => now()
    ]);

    return $this->sendResponse(new UserResource($user), 'User banned.');
}
/**
 * @OA\Post(
 *   path="/api/users/{id}/unban",
 *   summary="Unban user",
 *   tags={"Users"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User unbanned"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
public function unban($id)
{
    $user = User::find($id);
    if (!$user) {
        return $this->sendError('User not found.', 404);
    }

    $user->update([
        'is_banned' => false,
        'ban_reason' => null,
        'banned_at' => null
    ]);

    return $this->sendResponse(new UserResource($user), 'User unbanned.');
}
}
