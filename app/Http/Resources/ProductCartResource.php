<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'product' => $this->whenLoaded('product', fn() => new ProductResource($this->product)),
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
