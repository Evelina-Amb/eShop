<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Models\Favorite;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

/**
 * @OA\Post(
 *   path="/api/favorite",
 *   summary="Add listing to favorites",
 *   tags={"Favorites"},
 *   security={{"sanctum":{}}},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"listing_id"},
 *       @OA\Property(property="listing_id", type="integer")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Favorite created")
 * )
 */

    public function store(StoreFavoriteRequest $request)
{
    try {
            $favorite = $this->favoriteService->create([
                'user_id' => auth()->id(),
                'listing_id' => $request->listing_id,
            ]);
        return response()->json($favorite, 201);

    } catch (\Exception $e) {
        return response()->json([
                'message' => $e->getMessage(),
            ], 400);
    }
}

/**
 * @OA\Delete(
 *   path="/api/favorite/{listingId}",
 *   summary="Remove listing from favorites",
 *   tags={"Favorites"},
 *   security={{"sanctum":{}}},
 *   @OA\Parameter(
 *     name="listingId",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Favorite removed")
 * )
 */

    public function destroyByListing(int $listingId)
    {
        Favorite::where('user_id', auth()->id())
            ->where('listing_id', $listingId)
            ->delete();

        return response()->json(['ok' => true]);
    }
}
