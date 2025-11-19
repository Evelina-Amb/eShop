<?php

namespace App\Repositories\Contracts;

use App\Models\ListingPhoto;
use Illuminate\Support\Collection;

interface ListingPhotoRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?ListingPhoto;
    public function create(array $data): ListingPhoto;
    public function update(ListingPhoto $photo, array $data): ListingPhoto;
    public function delete(ListingPhoto $photo): bool;
}
