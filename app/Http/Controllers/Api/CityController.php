<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Resources\CityResource;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;

class CityController extends BaseController
{
    public function index()
    {
        $items = City::with('country')->get();
        return $this->sendResponse(CityResource::collection($items), 'Miestai gauti.');
    }

    public function show($id)
    {
        $item = City::with('country')->find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);

        return $this->sendResponse(new CityResource($item), 'Miestas rastas.');
    }

    public function store(StoreCityRequest $request)
    {
        $item = City::create($request->validated());
        return $this->sendResponse(new CityResource($item), 'Miestas sukurtas.', 201);
    }

    public function update(UpdateCityRequest $request, $id)
    {
        $item = City::find($id);
        if (!$item) return $this->sendError('Miestas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new CityResource($item), 'Miestas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = City::find($id);
        if (!$item) return $this->sendError('Miestas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Miestas ištrintas.');
    }
}
