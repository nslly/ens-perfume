<?php

namespace App\Http\Resources;

use App\Enums\GenderIdentification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'category' => $this->category,
            'brand' => $this->brand,
            'description' => $this->description,
            'volume' => $this->volume,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'images' => $this->images,
            'gender' => $this->gender->value ?? null,
        ];
    }
}
