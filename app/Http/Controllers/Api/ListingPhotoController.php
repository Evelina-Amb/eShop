<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ListingPhotoResource;
use App\Services\ListingPhotoService;
use App\Http\Requests\StoreListingPhotoRequest;
use App\Http\Requests\UpdateListingPhotoRequest;
use App\Http\Resources\BaseCollection;
use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Storage;

class ListingPhotoController extends BaseController
{
    protected ListingPhotoService $listingPhotoService;

    public function __construct(ListingPhotoService $listingPhotoService)
    {
        $this->listingPhotoService = $listingPhotoService;
    }
/**
 * @OA\Get(
 *   path="/api/listingPhoto",
 *   summary="Get all listing photos",
 *   tags={"Listing Photos"},
 *   @OA\Response(
 *     response=200,
 *     description="Listing photos retrieved"
 *   )
 * )
 */
    public function index()
    {
        $photos = $this->listingPhotoService->getAll();
        return $this->sendResponse(new BaseCollection($photos, ListingPhotoResource::class), 'Listing photos retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/listingPhoto/{id}",
 *   summary="Get single listing photo",
 *   tags={"Listing Photos"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Listing photo found"),
 *   @OA\Response(response=404, description="Listing photo not found")
 * )
 */
    public function show($id)
    {
        $photo = $this->listingPhotoService->getById($id);
        if (!$photo) return $this->sendError('Listing photo not found.', 404);

        return $this->sendResponse(new ListingPhotoResource($photo), 'Listing photo found.');
    }
/**
 * @OA\Post(
 *   path="/api/listingPhoto",
 *   summary="Upload listing photo",
 *   tags={"Listing Photos"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"listing_id","failo_url"},
 *       @OA\Property(property="listing_id", type="integer"),
 *       @OA\Property(property="failo_url", type="string")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Listing photo created"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
    public function store(StoreListingPhotoRequest $request)
    {
        $photo = $this->listingPhotoService->create($request->validated());
        return $this->sendResponse(new ListingPhotoResource($photo), 'Listing photo created.', 201);
    }
/**
 * @OA\Put(
 *   path="/api/listingPhoto/{id}",
 *   summary="Update listing photo",
 *   tags={"Listing Photos"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="failo_url", type="string")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Listing photo updated"),
 *   @OA\Response(response=404, description="Listing photo not found")
 * )
 */
    public function update(UpdateListingPhotoRequest $request, $id)
    {
        $photo = $this->listingPhotoService->update($id, $request->validated());
        if (!$photo) return $this->sendError('Listing photo not found.', 404);

        return $this->sendResponse(new ListingPhotoResource($photo), 'Listing photo updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/listingPhoto/{id}",
 *   summary="Delete listing photo",
 *   tags={"Listing Photos"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Listing photo deleted"),
 *   @OA\Response(response=400, description="Must keep at least one photo"),
 *   @OA\Response(response=404, description="Listing photo not found")
 * )
 */
    public function destroy($id)
    {
        $photo = ListingPhoto::find($id);
        
        if (!$photo) {
            return $this->sendError('Listing photo not found.', 404);
        }

        $listing = $photo->listing;

        if ($listing->photos()->count() <= 1) {
            return $this->sendError('You must keep at least one photo.', 400);
        }

        Storage::delete('public/' . $photo->failo_url);

        $photo->delete();

        return $this->sendResponse(null, 'Listing photo deleted.');
    }
}
