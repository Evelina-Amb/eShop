<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getAll(): Collection
    {
        return Cart::with(['user', 'Listing'])->get();
    }

    public function getById(int $id): ?Cart
    {
        return Cart::with(['user', 'Listing'])->find($id);
    }

    public function create(array $data): Cart
    {
        return Cart::create($data);
    }

    public function update(Cart $cart, array $data): Cart
    {
        $cart->update($data);
        return $cart;
    }

    public function delete(Cart $cart): bool
    {
        return $cart->delete();
    }
}
