<?php

namespace App\Repositories\Contracts;

use App\Models\Review;
use Illuminate\Support\Collection;

interface ReviewRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Review;
    public function create(array $data): Review;
    public function update(Review $review, array $data): Review;
    public function delete(Review $review): bool;
}
