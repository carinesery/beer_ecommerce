<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        /** Vérifiez si l'utilisateur est connecté sans middleware : 
        * if (!$userId) {
        *     return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre panier.');
        * }
        * $user = User::findOrFail($userId);
        */

        $order = Order::where('user_id', $user->id)
            ->where('status', 'cart')
            ->with('items.productVariant.product') // on charge les items + relations imbriquées
            ->first();

        /** Pour un front React */
        if (!$order || $order->items->isEmpty()) {
            return response()->json([
                'message' => 'Votre panier est vide.',
                'panier' => null
            ], 200);
        }

        return response()->json([
            'panier' => $order,
            'user' => $user
        ]);

        /** Pour un front Blade :
        * if (!$order || $order->items->isEmpty()) {
        *   return redirect()->route('homepage')->with('error', 'Votre panier est vide.');
        * }

        * return view('cart/show',[
        *    'order' => $order,
        *    'orderItems' => $order->items,
        *    'user' => $user,
        * ]);
        */
        
    }


    public function checkout() 
    {
        
        $user = auth()->user();

        if(!$user){
            return response()->json([
                'message' => 'Utilisateur no authentifié'
            ], 401);
        }

        /** 1. Récupérer le panier actuel de l'utilisateur connecté */ 
        $order = Order::where('user_id', $user->id)
            ->where('status', 'cart')
            ->with('items.productVariant.product')
            ->first();


        /** Pour un front React 
        * 2. Vérifier qu’il existe un panier et le retourner */
        if (!$order || $order->items->isEmpty()) {
            return response()->json([
                'message' => 'Votre panier est vide.',
                'panier' => 'null'
            ], 200);
        }

        return response()->json([
            'order' => $order,
            'user' => $user
        ]);


        /** Pour un front Blade 
        * 2. Vérifier qu’il existe un panier et le retourner
        * if (!$order || $order->items->isEmpty()) {
        *     return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        * }

        * return view('cart/checkout', ['order' => $order, 'user' => $user]);
        */
    }


}
