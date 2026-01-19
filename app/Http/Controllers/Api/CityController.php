<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\BaseCollection;
use App\Services\CityService;

class CityController extends BaseController
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }
/**
 * @OA\Get(
 *   path="/api/city",
 *   summary="Get all cities",
 *   tags={"City"},
 *   @OA\Response(
 *     response=200,
 *     description="Cities retrieved"
 *   )
 * )
 */
    public function index()
    {
        $cities = $this->cityService->getAll();
        return $this->sendResponse(new BaseCollection($cities, CityResource::class), 'Cities retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/city/{id}",
 *   summary="Get single city",
 *   tags={"City"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="City found"),
 *   @OA\Response(response=404, description="City not found")
 * )
 */
    public function show($id)
    {
        $city = $this->cityService->getById($id);
        if (!$city) return $this->sendError('City not found.', 404);

        return $this->sendResponse(new CityResource($city), 'City found.');
    }
/**
 * @OA\Post(
 *   path="/api/city",
 *   summary="Create city",
 *   tags={"City"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string"),
 *       @OA\Property(property="country_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=201, description="City created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreCityRequest $request)
    {
        $city = $this->cityService->create($request->validated());
        return $this->sendResponse(new CityResource($city), 'City created.', 201);
    }
/**
 * @OA\Put(
 *   path="/api/city/{id}",
 *   summary="Update city",
 *   tags={"City"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string"),
 *       @OA\Property(property="country_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=200, description="City updated"),
 *   @OA\Response(response=404, description="City not found")
 * )
 */
    public function update(UpdateCityRequest $request, $id)
    {
        $city = $this->cityService->update($id, $request->validated());
        if (!$city) return $this->sendError('City not found.', 404);

        return $this->sendResponse(new CityResource($city), 'City updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/city/{id}",
 *   summary="Delete city",
 *   tags={"City"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="City deleted"),
 *   @OA\Response(response=404, description="City not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->cityService->delete($id);
        if (!$deleted) return $this->sendError('City not found.', 404);

        return $this->sendResponse(null, 'City deleted.');
    }
}
