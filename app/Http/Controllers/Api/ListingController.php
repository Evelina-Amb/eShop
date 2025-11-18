<?php

namespace App\Http\Controllers\Api;

use App\Models\Listing;
use App\Http\Resources\ListingResource;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;

class ListingController extends BaseController
{
    public function index()
    {
        $items = Listing::with(['user', 'kategorija', 'nuotraukos'])->get();
        return $this->sendResponse(ListingResource::collection($items), 'Visi skelbimai sėkmingai gauti.');
    }

    public function show($id)
    {
        $item = Listing::with(['user', 'kategorija', 'nuotraukos'])->find($id);
        if (!$item) return $this->sendError('Skelbimas nerastas', 404);

        return $this->sendResponse(new ListingResource($item), 'Skelbimas rastas.');
    }

    public function store(StoreListingRequest $request)
    {
        $item = Listing::create($request->validated());
        return $this->sendResponse(new ListingResource($item), 'Skelbimas sukurtas sėkmingai.', 201);
    }

    public function update(UpdateListingRequest $request, $id)
    {
        $item = Listing::find($id);
        if (!$item) return $this->sendError('Skelbimas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new ListingResource($item), 'Skelbimas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Listing::find($id);
        if (!$item) return $this->sendError('Skelbimas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Skelbimas ištrintas.');
    }
}
