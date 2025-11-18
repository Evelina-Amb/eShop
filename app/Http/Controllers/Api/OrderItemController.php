<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;

class OrderItemController extends BaseController
{
    public function index()
    {
        $items = OrderItem::with(['Order', 'Listing'])->get();
        return $this->sendResponse(OrderItemResource::collection($items), 'Pirkimo prekės gautos.');
    }

    public function show($id)
    {
        $item = OrderItem::with(['Oreder', 'Listing'])->find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        return $this->sendResponse(new OrderItemResource($item), 'Pirkimo prekė rasta.');
    }

    public function store(StoreOrderItemRequest $request)
    {
        $item = OrderItem::create($request->validated());
        return $this->sendResponse(new OrderItemResource($item), 'Pirkimo prekė pridėta.', 201);
    }

    public function update(UpdateOrderItemRequest $request, $id)
    {
        $item = OrderItem::find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        $item->update($request->validated());
        return $this->sendResponse(new OrderItemResource($item), 'Pirkimo prekė atnaujinta.');
    }

    public function destroy($id)
    {
        $item = OrderItem::find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        $item->delete();
        return $this->sendResponse(null, 'Pirkimo prekė ištrinta.');
    }
}
