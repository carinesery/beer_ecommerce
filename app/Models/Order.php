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
    ];
    /**Le cast permet à Laravel de :
        - Enregistrer automatiquement le champ address en JSON lors du save()/update()
        - Et le récupérer comme un tableau associatif PHP
    */

    public function recalculateTotals()
    {   
        $this->total_price_without_tax = $this->items->sum(fn($item) => $item->price_without_tax);
        $this->total_price_with_tax = $this->items->sum(fn($item) => $item->priceWithTax());
        $this->save();
    }

}
