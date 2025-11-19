<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Support\Collection;

class ListingRepository implements ListingRepositoryInterface
{
    public function getAll(): Collection
    {
        return Listing::with(['user', 'Category', 'ListingPhoto'])->get();
    }

    public function getById(int $id): ?Listing
    {
        return Listing::with(['user', 'Category', 'ListingPhoto'])->find($id);
    }

    public function create(array $data): Listing
    {
        return Listing::create($data);
    }

    public function update(Listing $listing, array $data): Listing
    {
        $listing->update($data);
        return $listing;
    }

    public function delete(Listing $listing): bool
    {
        return $listing->delete();
    }
}
