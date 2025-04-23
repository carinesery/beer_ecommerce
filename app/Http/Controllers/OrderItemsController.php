<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.show');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
    $validated = $request->validate([
        'product_variant_id' => 'required|exists:product_variants,id',
        'quantity' => 'required|integer|min:1',
        'price_without_tax' => 'required|numeric|min:0',
        'price_with_tax' => 'required|numeric|min:0',
        'tax_amount' => 'required|numeric|min:0',
    ]);

    // Étape 1 : Créer une commande
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour passer une commande.');
    }
    
    /** 2 pbs ici : 
     * - on crée automatiquement un order sans vérifier qu'il y en a déjà un 
     * - les champs avec les prix sont complétés avec les champs de l'article 
     * ajouté au panier, ce qui suppose qu'on n'ajoute qu'un seul article au 
     * panier ... ici ils ne représentent pas la somme */
    // $order = Order::create([
    //     'user_id' => auth()->user()->id,
    //     'status' => 'cart',
    //     'total_price_without_tax' => $validated['price_without_tax']*$validated['quantity'],
    //     'total_price_with_tax' => $validated['price_with_tax']*$validated['quantity'],
    //     'tax_amount' => $validated['tax_amount'],
        
    // ]);

    // Étape 1 : Récupérer ou créer une commande existante
    $order = Order::firstOrCreate(
        [
        'user_id' => auth()->user()->id,
        'status' => 'cart'
        ],
        [ // valeurs par défaut SI AUCUN Order n'existe
        'total_price_without_tax' => 0,
        'total_price_with_tax' => 0,
        'tax_amount' => 10,
        ]);

    // Etape 2 : Vérifier si l'artcile existe déjà dans la commande 
    $orderItem = $order->items()->where('product_variant_id', $validated['product_variant_id'])->first();
    // Étape 3 : Ajouter l'article à la commande
    if($orderItem) {
        // Mettre à jour la quantité du produit 
        $orderItem->quantity += $validated['quantity'];
        $orderItem->price_without_tax = $validated['price_without_tax'];
        $orderItem->price_with_tax = $validated['price_with_tax'];
        $orderItem->tax_amount = $validated['tax_amount'];
        $orderItem->save();
    } else {
        // Créer un nouvel article
        $orderItem = $order->items()->create([
            'product_variant_id' => $validated['product_variant_id'],
            'quantity' => $validated['quantity'],
            'price_without_tax' => $validated['price_without_tax'],
            'price_with_tax' => $validated['price_with_tax'],
            'tax_amount' => $validated['tax_amount'],
    ]);
    }

    // Etape 4 : Recalculer les totaux de la commande
    $totalWithoutTax = $order->items->sum(function($item) {
        return $item->price_without_tax * $item->quantity;
    }); 

    $totalWithTax = $order->items->sum(function($item) {
        return $item->price_with_tax * $item->quantity;
    });

    $order->update([
        'total_price_without_tax' => $totalWithoutTax,
        'total_price_with_tax' => $totalWithTax,
    ]);

    return back()->with('success', 'Produit ajouté au panier !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
