<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'total_price_without_tax',
        'total_price_with_tax',
        'tax_amount',
        'status',
        'address',
    ];

    protected $casts = [
        'address' => 'array',
    ];

    public function recalculateTotals()
    {   
        // foreach ($this->items as $item) {
        //     dump([
        //         'Produit' => $item->productVariant->product->name ?? 'Inconnu',
        //         'Prix HT unitaire' => $item->price_without_tax,
        //         'Prix TTC unitaire' => $item->price_with_tax,
        //         'Quantité' => $item->quantity,
        //         'Total HT' => $item->price_without_tax * $item->quantity,
        //         'Total TTC' => $item->price_with_tax * $item->quantity,
        //     ]);
        // }
        $this->total_price_without_tax = $this->items->sum(fn($item) => $item->price_without_tax); // * $item->quantity
        $this->total_price_with_tax = $this->items->sum(fn($item) => $item->priceWithTax()); // * $item->quantity
        // $this->tax_amount = $this->total_price_with_tax - $this->total_price_without_tax;
        $this->save();
    }

}
