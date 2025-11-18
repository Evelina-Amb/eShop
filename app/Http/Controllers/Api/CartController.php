<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Resources\CartResource;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends BaseController
{
    public function index()
    {
        $krepselis = Cart::with(['user', 'Listing'])->get();
        return $this->sendResponse(CartResource::collection($krepselis), 'Krepšelis gautas.');
    }

    public function show($id)
    {
        $item = Cart::with(['user', 'Listing'])->find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        return $this->sendResponse(new CartResource($item), 'Krepšelio įrašas rastas.');
    }

    public function store(StoreCartRequest $request)
    {
        $item = Cart::create($request->validated());
        return $this->sendResponse(new CartResource($item), 'Prekė pridėta į krepšelį.', 201);
    }

    public function update(UpdateCartRequest $request, $id)
    {
        $item = Cart::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new CartResource($item), 'Krepšelio įrašas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Cart::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Prekė pašalinta iš krepšelio.');
    }
}
