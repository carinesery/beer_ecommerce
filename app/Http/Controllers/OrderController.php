<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // Voir l'ensemble des commandes passées
    {
        $orders = Order::with('items')
                ->where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'completed', 'delivered', 'cancelled'])
                ->get();


        return view('orders.index', compact('orders'));
    }

    
    public function store(Request $request)
    {

        // 1. Validation
        $request->validate([
        // 'civility' => 'required|in:M.,Mme',
        // 'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        'address' => 'required|string|max:255',
        'zipcode' => 'required|digits_between:4,10',
        'city' => 'required|string|max:255',
        'privacy-policy' => 'accepted',
        'terms-of-sale' => 'accepted',
        ]);

        // 2. Récupérer l'utilisateur
        $user = Auth::user();

        // 3. Récupérer la commande existante avec statut "cart"
        $order = Order::where('user_id', $user->id)
        ->where('status', 'cart')
        ->with('items')
        ->first();

        if (!$order || $order->items->isEmpty()) {
        return redirect()->route('cart')->with('error', 'Votre panier est vide.');
        }

        // 4. Mise à jour des infos de la commande
        $order->status = 'pending';
        $order->validated_at = now();

        $order->address = [
            'phone' => $request->phone,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
        ];
        
        $order->save();

        // 5. Rediriger vers la page de confirmation ou de paiement
        return redirect()->route('orders.redirect', ['order' => $order->id]);

    }

    public function show($orderId) // Voir une commande passée 
    {
        $order = Order::where('id', $orderId)
                ->with('items.productVariant.product', 'user')
                ->findOrFail($orderId);
       
        return view('orders.show', compact('order'));
    }

    public function resumePayment($orderId) {

        // Vérifier que l'utilisateur a une commande statut pending

        $order = Order::where('id', $orderId)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->with('items')
                ->firstOrFail();

        // Diriger vers la page de confirmation ou de paiement
        return redirect()->route('orders.redirect', ['order' => $order->id]);

    }

}
