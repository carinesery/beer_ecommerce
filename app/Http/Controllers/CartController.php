<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userId = auth()->user()->id;

        // dd($userId);
        // Vérifiez si l'utilisateur est connecté
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre panier.');
        }
        $user = User::findOrFail($userId);
        // dd($user);


        // $orders = $user->orders;
        // // Vérifiez si l'utilisateur a des commandes
        // if ($orders->isEmpty()) {
        //     return redirect()->route('products.index')->with('error', 'Votre panier est vide.');
        // }
        // // dd($orders);

        /** Problème ici selon chatGPT : tous les ordersItems de toutes les commandes sont récup' */
        // $orderItems = OrderItem::with(['order', 'productVariant.product']) // chargement des relations imbriquées
        // ->whereHas('order', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })
        // ->get();

        // dd($orderItems);

        $order = Order::where('user_id', $userId)
            ->where('status', 'cart')
            ->with('items.productVariant.product') // on charge les items + relations imbriquées
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('homepage')->with('error', 'Votre panier est vide.');
        }

        return view('cart/show',[
            'orderItems' => $order->items,
            'user' => $user,
        ]);
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

    public function checkout() 
    {
        
        $user = Auth::user();

         // 1. Récupérer le panier actuel de l'utilisateur connecté
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'cart')
            ->with('items.productVariant.product')
            ->first();

        // 2. Vérifier qu’il existe un panier
        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        // // 3. Vérifier les stocks sur les variants
        // foreach ($order->items as $item) { // orderItems ?
        //     $variant = $item->productVariant;

        //     if ($variant->stock < $item->quantity) { 
        //         return redirect()->route('cart')->with('error', "Le produit {$variant->product->name} - {$variant->name} n'est plus disponible en quantité suffisante.");
        //     };
        // }

        return view('cart/checkout', ['order' => $order, 'user' => $user]);
    }
}
