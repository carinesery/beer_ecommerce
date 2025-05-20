<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  
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
        'validated_at' => 'datetime',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];
    /**Le cast permet à Laravel de :
        - Enregistrer automatiquement le champ address en JSON lors du save()/update()
        - Et le récupérer comme un tableau associatif PHP
    */

    public function recalculateTotals()
    {   
        $this->load('items.productVariant.product'); // 🟢 recharge les données actualisées depuis la BDD

        $this->total_price_without_tax = $this->items->sum(fn($item) => $item->price_without_tax);
        $this->total_price_with_tax = $this->items->sum(fn($item) => $item->priceWithTax());
        $this->tax_amount = $this->items->sum(fn($item) => $item->priceWithTax() - $item->price_without_tax);
        $this->save();
    }

    /** Encapsulation propre pour la traduction des statuts des commandes */
    public function getStatusLabel(): string
    {
        return __('orders.status.' . $this->status);
    }

}
