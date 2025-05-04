<style>
    a {
        display: block;
        width: fit-content;
        padding: .5rem 1rem;
        border-radius: .5rem;
        border: 3px solid orangered;
    }
</style>

<x-layout title="Toutes les commandes">
    <h1>Toutes les commandes</h1>
    <ul>
        @foreach($orders as $order)
        <li><span>Commande</span>
            <span>
                    @if($order->status === 'pending')
                    validée le {{ $order->validated_at ? $order->validated_at->format('d-m-Y à H:i') : '(date inconnue)' }} (en attente de paiement)
                    @elseif($order->status === 'completed')
                    payée le {{ $order->paid_at ? $order->paid_at->format('d-m-Y à H:i') : '(date inconnue)' }}
                    @elseif($order->status === 'delivered')
                    envoyée le {{ $order->shipped_at ? $order->shipped_at->format('d-m-Y à H:i') : '(date inconnue)' }}
                    @elseif($order->status === 'cancelled')
                    annulée le {{ $order->cancelled_at ? $order->cancelled_at->format('d-m-Y à H:i') : '(date inconnue)' }}
                    @endif
            </span>
            <div>
                <div class="resume">
                    <span>Montant total : {{ number_format($order->total_price_with_tax/100, 2, ',', '') }} €</span>
                    
                </div>
                <a href="{{ route('orders.show', $order) }}">Voir la commande</a>
            </div>
        </li>
        @endforeach
    </ul>
</x-layout>