<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::with('adresas.miestas.salis')->get();
        return $this->sendResponse(UserResource::collection($users), 'Vartotojai sėkmingai gauti.');
    }

    public function show($id)
    {
        $user = User::with('adresas.miestas.salis')->find($id);
        if (!$user) return $this->sendError('Vartotojas nerastas', 404);

        return $this->sendResponse(new UserResource($user), 'Vartotojas rastas.');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['slaptazodis'] = bcrypt($data['slaptazodis']);

        $user = User::create($data);
        return $this->sendResponse(new UserResource($user), 'Vartotojas sukurtas.', 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) return $this->sendError('Vartotojas nerastas', 404);

        $data = $request->validated();
        if (isset($data['slaptazodis'])) {
            $data['slaptazodis'] = bcrypt($data['slaptazodis']);
        }

        $user->update($data);
        return $this->sendResponse(new UserResource($user), 'Vartotojas atnaujintas.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return $this->sendError('Vartotojas nerastas', 404);

        $user->delete();
        return $this->sendResponse(null, 'Vartotojas ištrintas.');
    }
}
