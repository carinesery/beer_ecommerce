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
    <h1>Toutes des commandes</h1>
    <ul>
        @foreach($orders as $order)
        <li><span>Commande du {{ $order->created_at->format('d/m/Y') }}</span>
            <div>
                <div class="resume">
                    <span>Montant total : {{ number_format($order->total_price_with_tax/100, 2, ',', '') }} €</span>
                    <span>Statut :
                        @if($order->status === 'pending')
                        Validée
                        @elseif($order->status === 'completed')
                        Payée
                        @elseif($order->status === 'delivered')
                        Livrée
                        @elseif($order->status === 'cancelled')
                        Annulée
                        @endif
                    </span>
                </div>
                <a href="">Voir la commande</a>
            </div>
        </li>
        @endforeach
    </ul>
</x-layout>