<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price_without_tax',
        'price_with_tax',
        'tax_amount',
    ];

    public function priceWithTax() {
        return $this->price_without_tax + ($this->price_without_tax * $this->tax_amount)/100;
    }
}
