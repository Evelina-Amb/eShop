<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     */
    public function toArray(Request $request): array
    {
       return [
            'pavadinimas' => $this->pavadinimas,
            'aprasymas'   => $this->aprasymas,
            'kaina'       => (float) $this->kaina,
            'tipas'       => $this->tipas,
            'statusas'    => $this->statusas,
            'kategorija'  => new CategoryResource($this->whenLoaded('Category')),
            'pardavejas'  => new UserResource($this->whenLoaded('user')),
            'nuotraukos'  => ListingPhotoResource::collection($this->whenLoaded('ListingPhoto')),
            'sukurta'     => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
