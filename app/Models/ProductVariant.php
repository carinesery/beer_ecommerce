<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'slug',
        'volume',
        'stock_quantity',
        'price_without_tax',
        'tax_amount',
        'available',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
