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
        ->get();


        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $user = Auth::user();

        // $cart = $user->cart;

        // dd($cart);

        // return view('orders.checkout', compact('user', 'cart'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $order->update([
            'status' => 'pending',
            'address' => [
                // 'civility' => $request->civility,
                'phone' => $request->phone,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'city' => $request->city,
            ],
        ]);

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

    public function cancel($orderId) 
    {
        $order = Order::where('id', $orderId)
        ->where('user_id', auth()->id())
        ->whereIn('status', ['pending', 'completed']) // Annuler que certaines commandes
        ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Commande annulée avec succès.');
    }
}
