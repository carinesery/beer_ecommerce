<style>
    main {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        padding: 4rem 2rem;
    }

    h1 {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
    }
</style>
<x-layout title="Confirmation de commande">
    <main>
        <h1>Confirmation de commande</h1>
        <ul>Voici les informations saisies lors de votre commande :
            <li>Identité : {{ $order->user->firstname }} {{ $order->user->lastname }}</li>
            <li>Email : {{ $order->user->email }}</li>
            <li>Téléphone : {{ $order->address['phone'] ?? '-' }}</li>
            <li>Adresse : 
                @if($order->address)
                    {{ $order->address['address'] }}, {{ $order->address['zipcode'] }} {{ $order->address['city'] }}
                @else
                    Adresse non renseignée
                @endif
            </li>
            <li>Total TTC : {{ $order->total_price_with_tax }} €</li>
        </ul>

    </main>
</x-layout>    