<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingPhotoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'Listing_id' => 'required|exists:Listing,id',
            'failo_url'    => 'required|string|max:255'
        ];
    }
}

