<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'reviews' => ReviewResource::collection($this->collection),
        ];
    }
}
