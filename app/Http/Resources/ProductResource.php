<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Enums\GenderIdentification;
use Illuminate\Validation\Rules\Enum;
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
            'slug' => $this->slug,
            'name' => $this->name,
            'category' => $this->category,
            'brand' => $this->brand,
            'description' => $this->description,
            'volume' => $this->volume,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'images' => $this->images,
            'gender' => GenderIdentification::tryFrom($this->gender->value)?->name,
        ];
    }
}
