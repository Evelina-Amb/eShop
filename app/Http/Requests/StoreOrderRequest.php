<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'user_id'     => 'required|exists:users,id',
            'bendra_suma' => 'required|numeric|min:0',
            'statusas'    => 'required|string|in:completed,canceled,refunded'
        ];
    }
}
