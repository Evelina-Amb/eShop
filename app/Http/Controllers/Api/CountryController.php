<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Resources\CountryResource;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class CountryController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(CountryResource::collection(Country::all()), 'Šalys gautos.');
    }

    public function show($id)
    {
        $item = Country::find($id);
        if (!$item) return $this->sendError('Šalis nerasta', 404);

        return $this->sendResponse(new CountryResource($item), 'Šalis rasta.');
    }

    public function store(StoreCountryRequest $request)
    {
        $item = Country::create($request->validated());
        return $this->sendResponse(new CountryResource($item), 'Šalis sukurta.', 201);
    }

    public function update(UpdateCountryRequest $request, $id)
    {
        $item = Country::find($id);
        if (!$item) return $this->sendError('Šalis nerasta', 404);

        $item->update($request->validated());
        return $this->sendResponse(new CountryResource($item), 'Šalis atnaujinta.');
    }

    public function destroy($id)
    {
        $item = Country::find($id);
        if (!$item) return $this->sendError('Šalis nerasta', 404);

        $item->delete();
        return $this->sendResponse(null, 'Šalis ištrinta.');
    }
}
