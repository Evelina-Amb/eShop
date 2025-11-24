<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Support\Collection;

class ListingRepository implements ListingRepositoryInterface
{
    public function getAll(): Collection
    {
        return Listing::with(['user', 'category', 'listingPhoto'])->get();
    }

    public function getPublic(): Collection
    {
        return Listing::where('statusas', '!=', 'parduotas')
                  ->with(['user', 'category', 'listingPhoto'])
                  ->get();
    }

    public function getByUser(int $userId): Collection
{
    return Listing::where('user_id', $userId)
                  ->with(['category', 'listingPhoto'])
                  ->get();
}

    public function getById(int $id): ?Listing
    {
        return Listing::with(['user', 'category', 'listingPhoto'])->find($id);
    }

    public function create(array $data): Listing
    {
        return Listing::create($data);
    }

    public function search(array $filters): Collection
{
    $query = Listing::where('statusas', '!=', 'parduotas')
                    ->with(['user', 'category', 'listingPhoto']);

    // Keyword search
    if (!empty($filters['q'])) {
        $q = $filters['q'];
        $query->where(function($q2) use ($q) {
            $q2->where('pavadinimas', 'LIKE', "%{$q}%")
               ->orWhere('aprasymas', 'LIKE', "%{$q}%");
        });
    }

    // Category filter
    if (!empty($filters['category_id'])) {
        $query->where('Category_id', $filters['category_id']);
    }

    // Type filter (preke / paslauga)
    if (!empty($filters['tipas'])) {
        $query->where('tipas', $filters['tipas']);
    }

    // Price range
    if (!empty($filters['min_price'])) {
        $query->where('kaina', '>=', $filters['min_price']);
    }

    if (!empty($filters['max_price'])) {
        $query->where('kaina', '<=', $filters['max_price']);
    }

    return $query->get();
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
