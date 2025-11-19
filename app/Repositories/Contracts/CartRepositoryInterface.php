<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Cart;
    public function create(array $data): Cart;
    public function update(Cart $cart, array $data): Cart;
    public function delete(Cart $cart): bool;
}
