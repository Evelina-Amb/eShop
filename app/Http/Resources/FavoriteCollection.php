<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'favorites' => FavoriteResource::collection($this->collection),
        ];
    }
}
