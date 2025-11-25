<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListingPhotoCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'listing_photos' => ListingPhotoResource::collection($this->collection),
        ];
    }
}
