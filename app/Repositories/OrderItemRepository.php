<?php

namespace App\Repositories;

use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use Illuminate\Support\Collection;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function getAll(): Collection
    {
        return OrderItem::with(['order', 'listing'])->get();
    }

    public function getById(int $id): ?OrderItem
    {
        return OrderItem::with(['order', 'listing'])->find($id);
    }

    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public function update(OrderItem $item, array $data): OrderItem
    {
        $item->update($data);
        return $item;
    }

    public function delete(OrderItem $item): bool
    {
        return $item->delete();
    }
}
