<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends BaseController
{
    public function index()
    {
        $items = Order::with(['user', 'OrderItem'])->get();
        return $this->sendResponse(OrderResource::collection($items), 'Pirkimai gauti.');
    }

    public function show($id)
    {
        $item = Order::with(['user', 'OrderItem'])->find($id);
        if (!$item) return $this->sendError('Pirkimas nerastas', 404);

        return $this->sendResponse(new OrderResource($item), 'Pirkimas rastas.');
    }

    public function store(StoreOrderRequest $request)
    {
        $item = Order::create($request->validated());
        return $this->sendResponse(new OrderResource($item), 'Pirkimas sukurtas.', 201);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $item = Order::find($id);
        if (!$item) return $this->sendError('Pirkimas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new OrderResource($item), 'Pirkimas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Order::find($id);
        if (!$item) return $this->sendError('Pirkimas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Pirkimas ištrintas.');
    }
}
