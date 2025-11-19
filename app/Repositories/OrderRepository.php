<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll(): Collection
    {
        return Order::with(['user', 'orderItem'])->get();
    }

    public function getById(int $id): ?Order
    {
        return Order::with(['user', 'orderItem'])->find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }

    public function delete(Order $order): bool
    {
        return $order->delete();
    }
}
