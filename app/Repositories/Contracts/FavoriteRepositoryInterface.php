<?php

namespace App\Repositories\Contracts;

use App\Models\Favorite;
use Illuminate\Support\Collection;

interface FavoriteRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Favorite;
    public function create(array $data): Favorite;
    public function update(Favorite $favorite, array $data): Favorite;
    public function delete(Favorite $favorite): bool;
}
