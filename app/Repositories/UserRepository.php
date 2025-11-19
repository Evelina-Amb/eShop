<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::with(['Address', 'Listing', 'Review', 'Cart', 'Favorite', 'Order'])->get();
    }

    public function getById(int $id): ?User
    {
        return User::with(['Address', 'Listing', 'Review', 'Cart', 'Favorite', 'Order'])->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
