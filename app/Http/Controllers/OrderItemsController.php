<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;

class OrderItemsController extends Controller
{
    
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
        ]);

        // // Étape 1: Vérifier l'authentification
        // if (!auth()->check()) {
        //     return redirect()->route('login')->with('error', 'Vous devez être connecté pour passer une commande.');
        // }

        $user = $request->user(); 

        // Etape 2 : Récupérer ou créer une commande existante
        $order = Order::firstOrCreate(
            [
            'user_id' => $user->id,
            'status' => 'cart'
            ],
            [ // valeurs par défaut SI AUCUN Order n'existe
            'total_price_without_tax' => 0,
            'total_price_with_tax' => 0,
            'tax_amount' => 0,
            ]);

        // Etape 3 : Récupérer la variation de produit et calculer les champs prix HT, prix TTC et taxe
        $productVariant = ProductVariant::findOrFail($validated['product_variant_id']);

        $priceWithoutTax = $productVariant->price_without_tax * $validated['quantity'];
        $taxAmount = $productVariant->tax_amount;
        // $priceWithTax = $priceWithoutTax + ($priceWithoutTax*$taxAmount)/100;

        // Etape 3 : Vérifier si l'article existe déjà dans la commande 
        $orderItem = $order->items()->where('product_variant_id', $validated['product_variant_id'])->first();

        
        // Étape 3 : Ajouter l'article à la commande
        if($orderItem) {
            // Mettre à jour la quantité du produit 
            $orderItem->quantity += $validated['quantity'];

            // Mettre à jour le prix HT du produit
            $orderItem->price_without_tax = $productVariant->price_without_tax * $orderItem->quantity;

            $orderItem->tax_amount = $productVariant->tax_amount;
            $orderItem->price_with_tax = $orderItem->priceWithTax();
            $orderItem->save();
            
        } else {
            // Créer un nouvel article
            $orderItem = $order->items()->create([
                'product_variant_id' => $validated['product_variant_id'],
                'quantity' => $validated['quantity'],
                'price_without_tax' => $priceWithoutTax,
                'tax_amount' =>  $taxAmount,
                'price_with_tax' => 0, // temporaire, mise à jour ligne suivante :
            ]);
            $orderItem->price_with_tax = $orderItem->priceWithTax();
            $orderItem->save();
        }

        // Etape 4 : Recalculer les totaux de la commande
        $order->recalculateTotals();


        /** Pour un front React */
        return response()->json([
            'message' => 'Produit ajouté au panier',
            'item' => new OrderItemResource($orderItem)
        ], 201);

        /** Pour un front Blade 
        * return back()->with('success', 'Produit ajouté au panier !');
        */

    }


    public function update(Request $request, OrderItem $orderItem)
    {

        // Vérifie que l'utilisateur a bien accès à cette commande
        if ($orderItem->order->user_id !== auth()->id() || $orderItem->order->status !== 'cart') {
            return response()->json(['message' => 'Action non autorisée'], 403);
            // au lieu de abort(403) pour un front Blade
        }
        

        // Vérifie la quantité disponible
        $quantityAvailable = $orderItem->productVariant->stock_quantity;

        // Récupère la requête et valide ou pas en fontion notamment de la quantité
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$quantityAvailable],
        ]);

        // Mise à jour
        $orderItem->update($validated);

        // Mise à jour des prix HT et TC
        $productvariant = $orderItem->productVariant;
        $priceWithoutTax = $productvariant->price_without_tax * $orderItem->quantity;
        // $taxAmount = $orderItem->tax_amount;

        $orderItem->price_without_tax = $priceWithoutTax;
        $orderItem->price_with_tax = $orderItem->priceWithTax();
        $orderItem->save();

        // Recalcul des totaux 
        $orderItem->order->recalculateTotals();
        

        /** Pour un front React */
         return response()->json([
            'message' => 'Quantité mise à jour.',
            'item' => new OrderItemResource($orderItem)
        ]);

        /** Pour un front Blade 
        * return redirect()->route('cart');
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        $order = $orderItem->order;
        
        if($order->user_id !== auth()->id() || $order->status !== 'cart') {
            return response()->json(['message' => 'Action non autorisée.'], 403);
            // au lieu de abort(403) pour un front Blade
        }

        // Supprime l'item
        $orderItem->delete();

        // Recalcul les totaux
        $order->recalculateTotals();

        /** Pour un front React */
        return response()->json(['message' => 'Article supprimé du panier.']);

        /** Pour un front Blade 
        * return redirect()->route('cart')->with('success', 'Article enlevé du panier');
        */
    }
}
