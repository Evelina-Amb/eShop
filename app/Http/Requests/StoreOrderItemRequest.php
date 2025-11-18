<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'Order_id'  => 'required|exists:Order,id',
            'Listing_id' => 'required|exists:Listing,id',
            'kaina'        => 'required|numeric|min:0',
            'kiekis'       => 'required|integer|min:1'
        ];
    }
}
