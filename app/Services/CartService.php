<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getAll()
    {
        return $this->cartRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->cartRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->cartRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $cart = $this->cartRepository->getById($id);
        if (!$cart) return null;

        return $this->cartRepository->update($cart, $data);
    }

    public function delete(int $id)
    {
        $cart = $this->cartRepository->getById($id);
        if (!$cart) return false;

        return $this->cartRepository->delete($cart);
    }
}
