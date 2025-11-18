<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'pavadinimas' => 'required|string|max:100',
            'Country_id'    => 'required|exists:Country,id'
        ];
    }
}
