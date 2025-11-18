<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ivertinimas'  => 'required|integer|min:1|max:5',
            'komentaras'   => 'nullable|string',
            'Listing_id' => 'required|exists:Listing,id',
            'user_id'      => 'required|exists:users,id'
        ];
    }
}
