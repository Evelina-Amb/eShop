<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->orderRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->orderRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $order = $this->orderRepository->getById($id);
        if (!$order) return null;

        return $this->orderRepository->update($order, $data);
    }

    public function delete(int $id)
    {
        $order = $this->orderRepository->getById($id);
        if (!$order) return false;

        return $this->orderRepository->delete($order);
    }
}
