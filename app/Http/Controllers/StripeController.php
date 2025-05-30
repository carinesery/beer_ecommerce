<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use Stripe\Webhook;

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
            'payment_method_types' => ['card', 'paypal'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => config('app.frontend_url') . "/paiement-reussi?order_id={$order->id}",
            'cancel_url' => config('app.frontend_url') . "/paiement-echoue",
        ]);
        // $session = Session::create([
        //     'payment_method_types' => ['card', 'paypal'],
        //     'line_items' => $lineItems,
        //     'mode' => 'payment',
        //     'success_url' => config('app.frontend_url') . "/paiement-reussi?order_id={$order->id}",
        //     'cancel_url' => config('app.frontend_url') . "/paiement-echoue",
        //     'metadata' => [
        //         'order_id' => $order->id,
        //     ],
        // ]);

        /** Pour un front React */
        return response()->json([
            'checkout_url' => $session->url
        ]);

        /** Pour un front Blade
        * return redirect($session->url);
         */
    }

    // public function webhook(Request $request)
    // {
    //     $endpointSecret = config('services.stripe.webhook_secret');

    //     $payload = $request->getContent();
    //     $sigHeader = $request->header('Stripe-Signature');

    //     try {
    //         $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
    //     } catch (\UnexpectedValueException $e) {
    //         return response()->json(['error' => 'Invalid payload'], 400);
    //     } catch (\Stripe\Exception\SignatureVerificationException $e) {
    //         dd($e);
    //         return response()->json(['error' => 'Invalid signature'], 400);
    //     }

    //     // Traitement du paiement réussi
    //     if ($event->type === 'checkout.session.completed') {
    //         $session = $event->data->object;

    //         $orderId = $session->metadata->order_id ?? null;

    //         if ($orderId) {
    //             $order = Order::where('id', $orderId)
    //                         ->where('status', 'pending')
    //                         ->with('items.productVariant')
    //                         ->first();

    //             if ($order) {
    //                 $order->status = 'completed';
    //                 $order->paid_at = now();
    //                 $order->save();

    //                 foreach ($order->items as $item) {
    //                     $variant = $item->productVariant;
    //                     $variant->stock_quantity = max(0, $variant->stock_quantity - $item->quantity);
    //                     $variant->save();
    //                 }

    //                 Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
    //             }
    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }

    public function success(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        // Récupère la commande
        $order = Order::where('user_id', auth()->id())
                        ->where('id', $request->order_id)
                        // ->where('status', 'pending')
                        ->with('items.productVariant') // ajouté ici : important pour éviter une erreur plus bas
                        ->first(); /** firstOrFail() */
        
         if (!$order) {
            return response()->json([
                'message' => 'Commande non trouvée.',
            ], 404);
        }

         // Si la commande a déjà été payée
        if ($order->status === 'completed') {
            return response()->json([
                'message' => "La commande a été payée.",
                'order' => $order
            ]);
        }

        // Met à jour le statut de la commande ici
        if ($order && $order->status === 'pending') {
            $order->status = 'completed';
            $order->paid_at = now(); // ⬅️ Date/heure actuelle du paiement
            $order->save();

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

         // Si le statut est autre (ex : annulé), on ne fait rien
        return response()->json([
            'message' => "La commande ne peut pas être traitée dans son état actuel.",
        ], 400);
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
