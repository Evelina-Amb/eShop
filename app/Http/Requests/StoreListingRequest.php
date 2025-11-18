<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'pavadinimas'   => 'required|string|max:100',
            'aprasymas'     => 'required|string',
            'kaina'         => 'required|numeric|min:0',
            'tipas'         => 'required|string|in:preke,paslauga',
            'user_id'       => 'required|exists:users,id',
            'Category_id' => 'required|exists:Category,id',
            'statusas'      => 'nullable|string|in:aktyvus,rezervuotas,parduotas'
        ];
    }
}
