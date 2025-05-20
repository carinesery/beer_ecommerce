<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
        'product_variant_id' => $this->product_variant_id,
        'quantity' => $this->quantity,
        'price_without_tax' => $this->price_without_tax,
        'price_with_tax' => $this->price_with_tax,
        'tax_amount' => $this->tax_amount,
        // tu peux décider d'inclure ou non les relations
        'product_variant' => new ProductVariantResource($this->whenLoaded('productVariant')),
    ];
    }
}
