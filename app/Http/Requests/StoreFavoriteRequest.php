<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'Listing_id' => 'required|exists:Listing,id'
        ];
    }
}
