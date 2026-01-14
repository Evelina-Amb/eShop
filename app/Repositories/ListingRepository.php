<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Support\Collection;

class ListingRepository implements ListingRepositoryInterface
{
    protected Listing $model;

    public function __construct(Listing $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->getPublic();
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($listing, array $data)
    {
        $listing->update($data);
        return $listing;
    }

    public function delete($listing)
    {
        // HIDE INSTEAD OF HARD DELETE
        $listing->is_hidden = true;
        return $listing->save();
    }

    public function getPublic(): Collection
    {
        return Listing::where('is_hidden', false)
            ->where('statusas', '!=', 'parduotas')
            ->with(['user', 'category', 'photos'])
            ->get();
    }

    public function getByUser(int $userId): Collection
    {
        return Listing::where('user_id', $userId)
            ->where('is_hidden', false)
            ->with(['category', 'photos'])
            ->get();
    }

    public function search(array $filters): Collection
    {
        $query = Listing::where('is_hidden', false)
            ->where('statusas', '!=', 'parduotas')
            ->with([
                'user',
                'category',
                'photos',
                'user.Address.City',
                'review.user'
            ]);

        // Keyword search
        if (!empty($filters['q'])) {
            $q = $filters['q'];

            $query->where(function ($q2) use ($q) {
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

        // City filter
        if (!empty($filters['city_id'])) {
            $query->whereHas('user.address', function ($q) use ($filters) {
                $q->where('city_id', $filters['city_id']);
            });
        }

        return $query->get();
    }

    public function getByIds(array $ids): Collection
    {
        return Listing::where('is_hidden', false)
            ->whereIn('id', $ids)
            ->with(['photos', 'category', 'user'])
            ->withCount([
                'favorites as is_favorited' => function ($q) {
                    if (Auth::check()) {
                        $q->where('user_id', Auth::id());
                    } else {
                        $q->whereRaw('0 = 1');
                    }
                }
            ])
            ->get();
    }
}