<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\BaseCollection;

class ReviewController extends BaseController
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
/**
 * @OA\Get(
 *   path="/api/review",
 *   summary="Get all reviews",
 *   tags={"Reviews"},
 *   @OA\Response(
 *     response=200,
 *     description="Reviews retrieved"
 *   )
 * )
 */
    public function index()
    {
        $reviews = $this->reviewService->getAll();
        return $this->sendResponse(new BaseCollection($reviews, ReviewResource::class),'Reviews retrieved.');
    }
/**
 * @OA\Get(
 *   path="/api/review/{id}",
 *   summary="Get single review",
 *   tags={"Reviews"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Review found"),
 *   @OA\Response(response=404, description="Review not found")
 * )
 */
    public function show($id)
    {
        $review = $this->reviewService->getById($id);
        if (!$review) return $this->sendError('Review not found.', 404);

        return $this->sendResponse(new ReviewResource($review), 'Review found.');
    }
/**
 * @OA\Post(
 *   path="/api/review",
 *   summary="Create review",
 *   tags={"Reviews"},
 *   @OA\Response(response=201, description="Review created"),
 *   @OA\Response(response=400, description="Invalid input")
 * )
 */
    public function store(StoreReviewRequest $request)
    {
        try {
            $review = $this->reviewService->create($request->validated());
            return $this->sendResponse(new ReviewResource($review), 'Review created.', 201);
        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
/**
 * @OA\Put(
 *   path="/api/review/{id}",
 *   summary="Update review",
 *   tags={"Reviews"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Review updated"),
 *   @OA\Response(response=404, description="Review not found")
 * )
 */
    public function update(UpdateReviewRequest $request, $id)
    {
        $review = $this->reviewService->update($id, $request->validated());
        if (!$review) return $this->sendError('Review not found.', 404);

        return $this->sendResponse(new ReviewResource($review), 'Review updated.');
    }
/**
 * @OA\Delete(
 *   path="/api/review/{id}",
 *   summary="Delete review",
 *   tags={"Reviews"},
 *   @OA\Response(response=200, description="Review deleted"),
 *   @OA\Response(response=404, description="Review not found")
 * )
 */
    public function destroy($id)
    {
        $deleted = $this->reviewService->delete($id);
        if (!$deleted) return $this->sendError('Review not found.', 404);

        return $this->sendResponse(null, 'Review deleted.');
    }
}
