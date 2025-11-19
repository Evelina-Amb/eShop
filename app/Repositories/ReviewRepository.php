<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Support\Collection;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getAll(): Collection
    {
        return Review::with(['Listing', 'user'])->get();
    }

    public function getById(int $id): ?Review
    {
        return Review::with(['Listing', 'user'])->find($id);
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data): Review
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review): bool
    {
        return $review->delete();
    }
}
