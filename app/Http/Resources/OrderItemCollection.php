<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'order_items' => OrderItemResource::collection($this->collection),
        ];
    }
}
