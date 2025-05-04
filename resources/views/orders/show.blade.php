<x-layout title="Résumé de la commande">
    <main>
        <h1>Résumé de commande</h1>
        <p>Commande n° {{ $order->created_at->format('Ymd') }}-{{ $order->id }}</p>
        <ul>Produits commandés :  
        @foreach($order->items as $item)
            <li>{{ $item->productVariant->product->name }} - Quantité : {{ $item->quantity }} - Montant : {{ number_format($item->priceWithTax()/100, 2, ',', '') }} €</li>  
        @endforeach
            <li>Total HC : {{ number_format($order->total_price_without_tax/100, 2, ',', '') }} €</li>
            <li>Total TTC : {{ number_format($order->total_price_with_tax/100, 2, ',', '') }} €</li>
        </ul>
        <ul>Informations de livraison :
            <li>{{ $order->address['address'] }}</li>
            <li>{{ $order->address['zipcode'] }}</li>
            <li>{{ $order->address['city'] }}</li>
            <li>{{ $order->address['phone'] ?? 'Numéro de téléphone non communiqué ' }}</li>  
        </ul>
    </main>
</x-layout>