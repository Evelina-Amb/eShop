<?php

namespace App\Http\Controllers\Api;

use App\Models\ListingPhoto;
use App\Http\Resources\ListingPhotoResource;
use App\Http\Requests\StoreListingPhotoRequest;
use App\Http\Requests\UpdateListingPhotoRequest;

class ListingPhotoController extends BaseController
{
    public function index()
    {
        $items = ListingPhoto::with('Listing')->get();
        return $this->sendResponse(
            ListingPhotoResource::collection($items),
            'Skelbimų nuotraukos gautos.'
        );
    }

    public function show($id)
    {
        $item = ListingPhoto::with('Listing')->find($id);
        if (!$item) return $this->sendError('Nuotrauka nerasta', 404);

        return $this->sendResponse(new ListingPhotoResource($item), 'Nuotrauka rasta.');
    }

    public function store(StoreListingPhotoRequest $request)
    {
        $item = ListingPhoto::create($request->validated());
        return $this->sendResponse(new ListingPhotoResource($item), 'Nuotrauka įkelta.', 201);
    }

    public function update(UpdateListingPhotoRequest $request, $id)
    {
        $item = ListingPhoto::find($id);
        if (!$item) return $this->sendError('Nuotrauka nerasta', 404);

        $item->update($request->validated());
        return $this->sendResponse(new ListingPhotoResource($item), 'Nuotrauka atnaujinta.');
    }

    public function destroy($id)
    {
        $item = ListingPhoto::find($id);
        if (!$item) return $this->sendError('Nuotrauka nerasta', 404);

        $item->delete();
        return $this->sendResponse(null, 'Nuotrauka ištrinta.');
    }
}
