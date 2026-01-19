<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\BaseCollection;
use App\Services\CountryService;

class CountryController extends BaseController
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }
 /**
 * @OA\Get(
 *   path="/api/country",
 *   summary="Get all countries",
 *   tags={"Country"},
 *   @OA\Response(
 *     response=200,
 *     description="Countries retrieved"
 *   )
 * )
 */
    public function index()
    {
        $countries = $this->countryService->getAll();
        return $this->sendResponse(new BaseCollection($countries, CountryResource::class), 'Countries retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/country/{id}",
 *   summary="Get single country",
 *   tags={"Country"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Country found"),
 *   @OA\Response(response=404, description="Country not found")
 * )
 */
    public function show($id)
    {
        $country = $this->countryService->getById($id);
        if (!$country) return $this->sendError('Country not found.', 404);

        return $this->sendResponse(new CountryResource($country), 'Country found.');
    }
/**
 * @OA\Post(
 *   path="/api/country",
 *   summary="Create country",
 *   tags={"Country"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Country created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreCountryRequest $request)
    {
        $country = $this->countryService->create($request->validated());
        return $this->sendResponse(new CountryResource($country), 'Country created.', 201);
    }
/**
 * @OA\Put(
 *   path="/api/country/{id}",
 *   summary="Update country",
 *   tags={"Country"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="pavadinimas", type="string")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Country updated"),
 *   @OA\Response(response=404, description="Country not found")
 * )
 */
    public function update(UpdateCountryRequest $request, $id)
    {
        $country = $this->countryService->update($id, $request->validated());
        if (!$country) return $this->sendError('Country not found.', 404);

        return $this->sendResponse(new CountryResource($country), 'Country updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/country/{id}",
 *   summary="Delete country",
 *   tags={"Country"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Country deleted"),
 *   @OA\Response(response=404, description="Country not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->countryService->delete($id);
        if (!$deleted) return $this->sendError('Country not found.', 404);

        return $this->sendResponse(null, 'Country deleted.');
    }
}
