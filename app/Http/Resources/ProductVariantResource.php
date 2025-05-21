<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
        'volume' => $this->volume,
        'stock_quantity' => $this->stock_quantity,
        'price_without_tax' => $this->price_without_tax,
        'price_with_tax' => $this->price_with_tax,
        'tax_amount' => $this->tax_amount,
        'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
