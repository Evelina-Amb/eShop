<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use App\Http\Resources\FavoriteResource;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;

class FavoriteController extends BaseController
{
    public function index()
    {
        $items = Favorite::with(['user', 'Listing'])->get();
        return $this->sendResponse(FavoriteResource::collection($items), 'Įsiminti skelbimai gauti.');
    }

    public function show($id)
    {
        $item = Favorite::with(['user', 'Listing'])->find($id);
        if (!$item) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        return $this->sendResponse(new FavoriteResource($item), 'Įsimintas skelbimas rastas.');
    }

    public function store(StoreFavoriteRequest $request)
    {
        $item = Favorite::create($request->validated());
        return $this->sendResponse(new FavoriteResource($item), 'Skelbimas įsimintas.', 201);
    }

    public function update(UpdateFavoriteRequest $request, $id)
    {
        $item = Favorite::find($id);
        if (!$item) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new FavoriteResource($item), 'Įsimintas skelbimas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Favorite::find($id);
        if (!$item) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Skelbimas pašalintas iš įsimintų.');
    }
}
