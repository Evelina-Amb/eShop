<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends BaseController
{
    public function index()
    {
        $items = Review::with(['user', 'Listing'])->get();
        return $this->sendResponse(
            ReviewResource::collection($items),
            'Atsiliepimai gauti.'
        );
    }

    public function show($id)
    {
        $item = Review::with(['user', 'Listing'])->find($id);
        if (!$item) return $this->sendError('Atsiliepimas nerastas', 404);

        return $this->sendResponse(new ReviewResource($item), 'Atsiliepimas rastas.');
    }

    public function store(StoreReviewRequest $request)
    {
        $item = Review::create($request->validated());
        return $this->sendResponse(new ReviewResource($item), 'Atsiliepimas sukurtas.', 201);
    }

    public function update(UpdateReviewRequest $request, $id)
    {
        $item = Review::find($id);
        if (!$item) return $this->sendError('Atsiliepimas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new ReviewResource($item), 'Atsiliepimas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Review::find($id);
        if (!$item) return $this->sendError('Atsiliepimas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Atsiliepimas ištrintas.');
    }
}
