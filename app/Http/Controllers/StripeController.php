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
        $order = Order::where('user_id', auth()->id())->where('status', 'cart')->with('items.productVariant.product')->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = $order->items->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->productVariant->product->name . ' - ' . $item->productVariant->volume,
                    ],
                    'unit_amount' => intval($item->price_with_tax * 100), // en centimes
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        // Met à jour le statut de la commande ici
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();
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
