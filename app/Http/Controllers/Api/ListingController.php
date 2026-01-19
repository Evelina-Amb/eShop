<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Http\Resources\ListingResource;
use App\Services\ListingService;

class ListingController extends BaseController
{
    protected ListingService $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }
/**
 * @OA\Get(
 *   path="/api/listing",
 *   summary="Get all listings",
 *   tags={"Listings"},
 *   @OA\Response(
 *     response=200,
 *     description="Listings retrieved"
 *   )
 * )
 */
    public function index(Request $request)
    {
        // Favorites
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $listings = $this->listingService->getByIds($ids);

            return $this->sendResponse(
                ListingResource::collection($listings),
                'Favorites retrieved.'
            );
        }

        // Default: all listings
        $listings = $this->listingService->getAll();

        return $this->sendResponse(
            ListingResource::collection($listings),
            'Listings retrieved.'
        );
    }
/**
 * @OA\Get(
 *   path="/api/listings/mine",
 *   summary="Get authenticated user's listings",
 *   tags={"Listings"},
 *   @OA\Response(
 *     response=200,
 *     description="User listings retrieved"
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthenticated"
 *   )
 * )
 */
    public function mine(Request $request)
    {
        $userId = $request->user_id;
        $listings = $this->listingService->getMine($userId);

        return $this->sendResponse(ListingResource::collection($listings), 'Your listings retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/listing/{id}",
 *   summary="Get single listing",
 *   tags={"Listings"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Listing found"),
 *   @OA\Response(response=404, description="Listing not found")
 * )
 */
    public function show($id)
    {
        $listing = $this->listingService->getById($id);
        if (!$listing) return $this->sendError('Listing not found.', 404);

        return $this->sendResponse(new ListingResource($listing), 'Listing found.');
    }
/**
 * @OA\Post(
 *   path="/api/listing",
 *   summary="Create listing",
 *   tags={"Listings"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"pavadinimas","kaina","tipas","category_id"},
 *       @OA\Property(property="pavadinimas", type="string"),
 *       @OA\Property(property="aprasymas", type="string"),
 *       @OA\Property(property="kaina", type="number"),
 *       @OA\Property(property="tipas", type="string"),
 *       @OA\Property(property="category_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Listing created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreListingRequest $request)
    {
        $listing = $this->listingService->create($request->validated());
        return $this->sendResponse(new ListingResource($listing), 'Listing created.', 201);
    }
/**
 * @OA\Get(
 *   path="/api/listings/search",
 *   summary="Search listings",
 *   tags={"Listings"},
 *   @OA\Parameter(name="q", in="query", @OA\Schema(type="string")),
 *   @OA\Parameter(name="category_id", in="query", @OA\Schema(type="integer")),
 *   @OA\Parameter(name="tipas", in="query", @OA\Schema(type="string")),
 *   @OA\Parameter(name="min_price", in="query", @OA\Schema(type="number")),
 *   @OA\Parameter(name="max_price", in="query", @OA\Schema(type="number")),
 *   @OA\Parameter(name="sort", in="query", @OA\Schema(type="string")),
 *   @OA\Parameter(name="city_id", in="query", @OA\Schema(type="integer")),
 *   @OA\Response(response=200, description="Search results retrieved")
 * )
 */
    public function search(Request $request)
    {
        $filters = $request->only(['q', 'category_id', 'tipas', 'min_price', 'max_price', 'sort', 'city_id']);
        $results = $this->listingService->search($filters);

        return $this->sendResponse(ListingResource::collection($results), 'Search results retrieved.');
    }
/**
 * @OA\Put(
 *   path="/api/listing/{id}",
 *   summary="Update listing",
 *   tags={"Listings"},
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
 *       @OA\Property(property="aprasymas", type="string"),
 *       @OA\Property(property="kaina", type="number"),
 *       @OA\Property(property="tipas", type="string"),
 *       @OA\Property(property="category_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Listing updated"),
 *   @OA\Response(response=404, description="Listing not found")
 * )
 */
    public function update(UpdateListingRequest $request, $id)
    {
        try {
            $listing = $this->listingService->update($id, $request->validated());
            if (!$listing) return $this->sendError('Listing not found', 404);

            return $this->sendResponse(new ListingResource($listing), 'Listing updated.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
/**
 * @OA\Delete(
 *   path="/api/listing/{id}",
 *   summary="Delete listing",
 *   tags={"Listings"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Listing deleted"),
 *   @OA\Response(response=404, description="Listing not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->listingService->delete($id);
        if (!$deleted) return $this->sendError('Listing not found.', 404);

        return $this->sendResponse(null, 'Listing deleted.');
    }
}
