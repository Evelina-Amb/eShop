<?php

namespace App\Repositories\Contracts;

use App\Models\OrderItem;
use Illuminate\Support\Collection;

interface OrderItemRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?OrderItem;
    public function create(array $data): OrderItem;
    public function update(OrderItem $item, array $data): OrderItem;
    public function delete(OrderItem $item): bool;
}
