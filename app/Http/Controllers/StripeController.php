<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {

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

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Récupère la commande
        $order = Order::where('user_id', auth()->id())
                        ->where('id', $request->order_id)
                        ->where('status', 'pending')
                        ->firstOrFail();
        
        
        // Met à jour le statut de la commande ici
        if ($order) {
            $order->status = 'completed';
            $order->save();
        }

        return view('orders.confirmation', ['order' => $order]);
    }

    public function cancel()
    {
        return redirect()->route('cart')->with('error', 'Paiement annulé.');
    }
}
