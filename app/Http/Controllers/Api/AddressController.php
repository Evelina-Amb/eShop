<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Resources\AddressResource;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends BaseController
{
    public function index()
    {
        $items = Address::with('city.country')->get();
        return $this->sendResponse(AddressResource::collection($items), 'Adresai gauti.');
    }

    public function show($id)
    {
        $item = Address::with('city.country')->find($id);
        if (!$item) return $this->sendError('Adresas nerastas', 404);

        return $this->sendResponse(new AddressResource($item), 'Adresas rastas.');
    }

    public function store(StoreAddressRequest $request)
    {
        $item = Address::create($request->validated());
        return $this->sendResponse(new AddressResource($item), 'Adresas sukurtas.', 201);
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $item = Address::find($id);
        if (!$item) return $this->sendError('Adresas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new AddressResource($item), 'Adresas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Address::find($id);
        if (!$item) return $this->sendError('Adresas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Adresas ištrintas.');
    }
}
