<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $userId = auth()->user()->id;

        // Vérifiez si l'utilisateur est connecté
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre panier.');
        }
        $user = User::findOrFail($userId);

        $order = Order::where('user_id', $userId)
            ->where('status', 'cart')
            ->with('items.productVariant.product') // on charge les items + relations imbriquées
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('homepage')->with('error', 'Votre panier est vide.');
        }

        // dd($order->items);

        return view('cart/show',[
            'order' => $order,
            'orderItems' => $order->items,
            'user' => $user,
        ]);
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

        return view('cart/checkout', ['order' => $order, 'user' => $user]);
    }

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
