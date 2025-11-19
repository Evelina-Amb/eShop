<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use Illuminate\Support\Collection;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function getAll(): Collection
    {
        return Favorite::with(['user', 'listing'])->get();
    }

    public function getById(int $id): ?Favorite
    {
        return Favorite::with(['user', 'listing'])->find($id);
    }

    public function create(array $data): Favorite
    {
        return Favorite::create($data);
    }

    public function update(Favorite $favorite, array $data): Favorite
    {
        $favorite->update($data);
        return $favorite;
    }

    public function delete(Favorite $favorite): bool
    {
        return $favorite->delete();
    }
}
