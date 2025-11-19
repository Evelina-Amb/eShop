<?php

namespace App\Repositories;

use App\Models\ListingPhoto;
use App\Repositories\Contracts\ListingPhotoRepositoryInterface;
use Illuminate\Support\Collection;

class ListingPhotoRepository implements ListingPhotoRepositoryInterface
{
    public function getAll(): Collection
    {
        return ListingPhoto::with('listing')->get();
    }

    public function getById(int $id): ?ListingPhoto
    {
        return ListingPhoto::with('listing')->find($id);
    }

    public function create(array $data): ListingPhoto
    {
        return ListingPhoto::create($data);
    }

    public function update(ListingPhoto $photo, array $data): ListingPhoto
    {
        $photo->update($data);
        return $photo;
    }

    public function delete(ListingPhoto $photo): bool
    {
        return $photo->delete();
    }
}
