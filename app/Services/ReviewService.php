<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;

class ReviewService
{
    protected ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getAll()
    {
        return $this->reviewRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->reviewRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->reviewRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) return null;

        return $this->reviewRepository->update($review, $data);
    }

    public function delete(int $id)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) return false;

        return $this->reviewRepository->delete($review);
    }
}
