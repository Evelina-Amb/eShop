<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\OrderItemResource;
use App\Services\OrderItemService;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;

class OrderItemController extends BaseController
{
    protected OrderItemService $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    public function index()
    {
        $items = $this->orderItemService->getAll();
        return $this->sendResponse(OrderItemResource::collection($items), 'Order items retrieved.');
    }

    public function show($id)
    {
        $item = $this->orderItemService->getById($id);
        if (!$item) return $this->sendError('Order item not found.', 404);

        return $this->sendResponse(new OrderItemResource($item), 'Order item found.');
    }

    public function store(StoreOrderItemRequest $request)
    {
        $item = $this->orderItemService->create($request->validated());
        return $this->sendResponse(new OrderItemResource($item), 'Order item created.', 201);
    }

    public function update(UpdateOrderItemRequest $request, $id)
    {
        $item = $this->orderItemService->update($id, $request->validated());
        if (!$item) return $this->sendError('Order item not found.', 404);

        return $this->sendResponse(new OrderItemResource($item), 'Order item updated.');
    }

    public function destroy($id)
    {
        $deleted = $this->orderItemService->delete($id);
        if (!$deleted) return $this->sendError('Order item not found.', 404);

        return $this->sendResponse(null, 'Order item deleted.');
    }
}
