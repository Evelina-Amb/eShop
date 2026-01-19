<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\OrderItemResource;
use App\Services\OrderItemService;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\BaseCollection;

class OrderItemController extends BaseController
{
    protected OrderItemService $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }
/**
 * @OA\Get(
 *   path="/api/orderItem",
 *   summary="Get all order items",
 *   tags={"Order Items"},
 *   @OA\Response(
 *     response=200,
 *     description="Order items retrieved"
 *   )
 * )
 */
    public function index()
    {
        $OrderItems = $this->orderItemService->getAll();
        return $this->sendResponse(new BaseCollection($OrderItems, OrderItemResource::class), 'Order items retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/orderItem/{id}",
 *   summary="Get single order item",
 *   tags={"Order Items"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Order item found"),
 *   @OA\Response(response=404, description="Order item not found")
 * )
 */
    public function show($id)
    {
        $item = $this->orderItemService->getById($id);
        if (!$item) return $this->sendError('Order item not found.', 404);

        return $this->sendResponse(new OrderItemResource($item), 'Order item found.');
    }
/**
 * @OA\Post(
 *   path="/api/orderItem",
 *   summary="Direct creation of order items not allowed",
 *   tags={"Order Items"},
 *   @OA\Response(response=403, description="Direct creation forbidden")
 * )
 */
    public function store()
    {
        return $this->sendError('Direct creation of order items is not allowed.', 403);
    }
/**
 * @OA\Put(
 *   path="/api/orderItem/{id}",
 *   summary="Manual update of order items not allowed",
 *   tags={"Order Items"},
 *   @OA\Response(response=403, description="Manual update forbidden")
 * )
 */
    public function update()
    {
        return $this->sendError('Order items cannot be updated manually.', 403);
    }
/**
 * @OA\Delete(
 *   path="/api/orderItem/{id}",
 *   summary="Manual deletion of order items not allowed",
 *   tags={"Order Items"},
 *   @OA\Response(response=403, description="Manual deletion forbidden")
 * )
 */
    public function destroy()
    {
        return $this->sendError('Order items cannot be deleted manually.', 403);
    }

}
