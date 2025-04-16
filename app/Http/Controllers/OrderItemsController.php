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
    $order = Order::create([
        'user_id' => auth()->user()->id,
        'status' => 'cart',
        'total_price_without_tax' => $validated['price_without_tax']*$validated['quantity'],
        'total_price_with_tax' => $validated['price_with_tax']*$validated['quantity'],
        'tax_amount' => $validated['tax_amount'],
        
    ]);

    $order->items()->create([
        'product_variant_id' => $validated['product_variant_id'],
        'quantity' => $validated['quantity'],
        'price_without_tax' => $validated['price_without_tax'],
        'price_with_tax' => $validated['price_with_tax'],
        'tax_amount' => $validated['tax_amount'],
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
