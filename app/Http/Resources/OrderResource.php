<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'order_number'  => 'ORD-' . str_pad($this->id, 3, '0', STR_PAD_LEFT),
            'total'         => $this->total,
            'address'       => $this->address->address ?? null,
            'phone'         => $this->address->phone ?? null,
            'items'         => OrderItemResource::collection($this->items),
        ];

    }
}
