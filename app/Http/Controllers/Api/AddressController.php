<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\BaseCollection;
use App\Services\AddressService;

class AddressController extends BaseController
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }
/**
 * @OA\Get(
 *   path="/api/address",
 *   summary="Get all addresses",
 *   tags={"Addresses"},
 *   @OA\Response(
 *     response=200,
 *     description="Addresses retrieved"
 *   )
 * )
 */
    public function index()
    {
        $addresses = $this->addressService->getAll();
        return $this->sendResponse(new BaseCollection($addresses, AddressResource::class), 'Addresses retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/address/{id}",
 *   summary="Get single address",
 *   tags={"Addresses"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Address found"),
 *   @OA\Response(response=404, description="Address not found")
 * )
 */
    public function show($id)
    {
        $address = $this->addressService->getById($id);
        if (!$address) return $this->sendError('Address not found.', 404);

        return $this->sendResponse(new AddressResource($address), 'Address found.');
    }
/**
 * @OA\Post(
 *   path="/api/address",
 *   summary="Create new address",
 *   tags={"Addresses"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="street", type="string"),
 *       @OA\Property(property="city_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Address created")
 * )
 */
    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->create($request->validated());
        return $this->sendResponse(new AddressResource($address), 'Address created.', 201);
    }
/**
 * @OA\Put(
 *   path="/api/address/{id}",
 *   summary="Update address",
 *   tags={"Addresses"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="street", type="string"),
 *       @OA\Property(property="city_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Address updated"),
 *   @OA\Response(response=404, description="Address not found")
 * )
 */
    public function update(UpdateAddressRequest $request, $id)
    {
        $address = $this->addressService->update($id, $request->validated());
        if (!$address) return $this->sendError('Address not found.', 404);

        return $this->sendResponse(new AddressResource($address), 'Address updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/address/{id}",
 *   summary="Delete address",
 *   tags={"Addresses"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Address deleted"),
 *   @OA\Response(response=404, description="Address not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->addressService->delete($id);
        if (!$deleted) return $this->sendError('Address not found.', 404);

        return $this->sendResponse(null, 'Address deleted.');
    }
}
