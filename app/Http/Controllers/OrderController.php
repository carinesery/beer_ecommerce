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
        $orders = Order::with('items.productVariant.product')
                ->where('user_id', auth()->id()) // Auth::id()
                ->whereIn('status', ['pending', 'completed', 'delivered', 'cancelled'])
                ->orderByDesc('created_at')
                ->get();

        /** Pour un front React */
        return response()->json([
            'orders' => $orders
        ], 200);

        /** Pour un front Blade
        * return view('orders.index', compact('orders'));
        */
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
            return response()->json(['message' => 'Votre panier est vide'], 400);
            /** Pour un front blade : return redirect()->route('cart')->with('error', 'Votre panier est vide.'); */ 
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
        /** Pour un front React */ 
        return response()->json([
            'message' => 'Commande validée',
            'order' => $order,
            'redirect_url' => route('orders.redirect', ['order' => $order->id])
        ], 200);

        /** Pour un front Blade : 
        * return redirect()->route('orders.redirect', ['order' => $order->id]);
        */
    }
    

    public function redirectToStripe(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Accès interdit'], 403);
            /** Pour un front blade : abort(403); */
        }

        /** Pour un front React */
        return response()->json([
            'message' => 'Redirection vers Stripe',
            'order' => $order
        ], 200);

        /** Pour un front blade : 
        * return view('orders.redirect', compact('order'));
        */
    }


    public function show($orderId)
    {
        $order = Order::where('id', $orderId)
                ->where('user_id', auth()->id())
                ->with('items.productVariant.product', 'user')
                ->firstOrFail();

        if(!$order) {
            return response()->json(['message' => 'Commande introuvable.'], 404);
        }
       
        /** Pour un front React */
        return response()->json(['order' => $order], 200);

        /** Pour un front Blade : 
        * return view('orders.show', compact('order'));
        */
    }

    public function resumePayment($orderId) {

        // Vérifier que l'utilisateur a une commande statut pending
        $order = Order::where('id', $orderId)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->with('items')
                ->firstOrFail();

        if(!$order) {
             return response()->json(['message' => 'Commande introuvable ou déjà payée.'], 404);
        }

        // Diriger vers la page de confirmation ou de paiement

        /** Pour un front React */
        return response()->json([
            'message' => 'Redirection vers le paiement en cours ...',
            'order' => $order,
            'redirect_url' => route('orders.redirect', ['order' => $order->id])
        ]);

        /** Pour un front Blade
        * return redirect()->route('orders.redirect', ['order' => $order->id]);
         */
    }

}
