<?php

namespace App\Repositories\Contracts;

use App\Models\Listing;
use Illuminate\Support\Collection;

interface ListingRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Listing;
    public function create(array $data): Listing;
    public function update(Listing $listing, array $data): Listing;
    public function delete(Listing $listing): bool;
}
