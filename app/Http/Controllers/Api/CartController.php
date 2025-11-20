<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends BaseController
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $items = $this->cartService->getAll();
        return $this->sendResponse(CartResource::collection($items), 'Cart items retrieved.');
    }

    public function show($id)
    {
        $item = $this->cartService->getById($id);
        if (!$item) return $this->sendError('Cart item not found.', 404);

        return $this->sendResponse(new CartResource($item), 'Cart item found.');
    }

    public function store(StoreCartRequest $request)
    {
        try {
            $item = $this->cartService->create($request->validated());
            return $this->sendResponse(new CartResource($item), 'Cart item created.', 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function update(UpdateCartRequest $request, $id)
    {
        try {
            $item = $this->cartService->update($id, $request->validated());
            if (!$item) return $this->sendError('Cart item not found.', 404);

            return $this->sendResponse(new CartResource($item), 'Cart item updated.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->cartService->delete($id);
        if (!$deleted) return $this->sendError('Cart item not found.', 404);

        return $this->sendResponse(null, 'Cart item deleted.');
    }
}
