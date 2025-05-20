<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {

        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        
        $order = Order::where('user_id', auth()->id())
                        ->where('id', $request->order_id)
                        ->where('status', 'pending')
                        ->with('items.productVariant.product')
                        ->firstOrFail();
             
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = $order->items->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->productVariant->product->name . ' - ' . $item->productVariant->volume,
                    ],
                    'unit_amount' => intval($item->productVariant->productVariantPriceWithTax()),
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        // dd($lineItems); // <-- ici pour vérifier les montants en centimes

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['order_id' => $order->id]),
            'cancel_url' => route('stripe.cancel', ['order_id' => $order->id]),
        ]);

        /** Pour un front React */
        return response()->json([
            'checkout_url' => $session->url
        ]);

        /** Pour un front Blade
        * return redirect($session->url);
         */
    }

    public function success(Request $request)
    {

        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        // Récupère la commande
        $order = Order::where('user_id', auth()->id())
                        ->where('id', $request->order_id)
                        ->where('status', 'pending')
                        ->firstOrFail();
        
        
        // Met à jour le statut de la commande ici
        if ($order) {
            $order->status = 'completed';
            $order->paid_at = now(); // ⬅️ Date/heure actuelle du paiement
            $order->save();
        }

        foreach ($order->items as $item) {
            $variant = $item->productVariant;
            $variant->stock_quantity = max(0, $variant->stock_quantity - $item->quantity); // évite négatif
            $variant->save();
        }

        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

        /** Pour un front React */
        return response()->json([
            'message' => 'Le paiment de votre commande est confirmé.',
            'order' => $order
        ]);

        /** Pour un front Blade
        * return view('orders.confirmation', ['order' => $order]);
        */
    }

    public function cancel()
    {

        /** Pour un front React */
        return response()->json([
            'message' => 'Le paiment de votre commande a été annulé.'
        ]);

        /** Pour un front Blade
        * return redirect()->route('cart')->with('error', 'Paiement annulé.');
        */
    }
}
