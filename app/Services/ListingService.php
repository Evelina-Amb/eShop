<?php

namespace App\Services;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;

class ListingService
{
    protected ListingRepositoryInterface $listingRepository;

    public function __construct(ListingRepositoryInterface $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public function getAll()
    {
        return $this->listingRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->listingRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->listingRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $listing = $this->listingRepository->getById($id);
        if (!$listing) {
            return null;
        }

        return $this->listingRepository->update($listing, $data);
    }

    public function delete(int $id)
    {
        $listing = $this->listingRepository->getById($id);
        if (!$listing) {
            return false;
        }

        return $this->listingRepository->delete($listing);
    }
}
