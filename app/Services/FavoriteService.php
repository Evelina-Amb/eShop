<?php

namespace App\Services;

use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteRepositoryInterface;

class FavoriteService
{
    protected FavoriteRepositoryInterface $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getAll()
    {
        return $this->favoriteRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->favoriteRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->favoriteRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $favorite = $this->favoriteRepository->getById($id);
        if (!$favorite) return null;

        return $this->favoriteRepository->update($favorite, $data);
    }

    public function delete(int $id)
    {
        $favorite = $this->favoriteRepository->getById($id);
        if (!$favorite) return false;

        return $this->favoriteRepository->delete($favorite);
    }
}
