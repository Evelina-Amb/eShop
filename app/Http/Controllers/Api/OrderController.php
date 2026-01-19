<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\BaseCollection;
use App\Services\OrderService;

class OrderController extends BaseController
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
/**
 * @OA\Get(
 *   path="/api/order",
 *   summary="Get all orders",
 *   tags={"Orders"},
 *   @OA\Response(
 *     response=200,
 *     description="Orders retrieved"
 *   )
 * )
 */
    public function index()
    {
        $orders = Order::with(['user', 'orderItem'])->get();
        return $this->sendResponse(new BaseCollection($orders,  OrderResource::class),  'Pirkimai gauti.');
    }
/**
 * @OA\Get(
 *   path="/api/order/{id}",
 *   summary="Get single order",
 *   tags={"Orders"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Order found"),
 *   @OA\Response(response=404, description="Order not found")
 * )
 */
    public function show($id)
    {
        $item = Order::with(['user', 'orderItem'])->find($id);
        if (!$item) return $this->sendError('Pirkimas nerastas', 404);

        return $this->sendResponse(new OrderResource($item), 'Pirkimas rastas.');
    }
/**
 * @OA\Post(
 *   path="/api/order",
 *   summary="Create new order",
 *   tags={"Orders"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"user_id"},
 *       @OA\Property(property="user_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Order created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->create($request->validated());
            return $this->sendResponse(new OrderResource($order), 'Pirkimas sukurtas.', 201);

            } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
/**
 * @OA\Put(
 *   path="/api/order/{id}",
 *   summary="Orders cannot be updated",
 *   tags={"Orders"},
 *   @OA\Response(response=403, description="Orders cannot be updated")
 * )
 */
    public function update()
    {
        return $this->sendError('Orders cannot be updated.', 403);
    }
/**
 * @OA\Delete(
 *   path="/api/order/{id}",
 *   summary="Orders cannot be deleted",
 *   tags={"Orders"},
 *   @OA\Response(response=403, description="Orders cannot be deleted")
 * )
 */
    public function destroy()
    {
        return $this->sendError('Orders cannot be deleted.', 403);
    }

}
