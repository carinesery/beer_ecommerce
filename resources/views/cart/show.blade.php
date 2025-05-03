<style>
    .to-checkout {
        display: flex;
        width: fit-content;
        justify-self: flex-end;
        padding: .5rem 1rem;
        background-color: orangered;
        color: white;
        margin: 2rem;
        border-radius: .5rem;
    }
</style>

<x-layout title="Panier">
    <h1>Page panier</h1>
    @foreach ($orderItems as $item)
    <div class="grid items-center grid-cols-[_100px_repeat(5,_minmax(100px,_1fr))] gap-1 bg-gray-200 ">
        <div class="p-4">
            <img src="{{ $item->productVariant->product->image}}" alt="image produit">
        </div>
        <div class="p-4">
            <span>Nom du produit :</span>
            <span>{{ $item->productVariant->product->name ?? 'Produit inconnu' }}</span>

        </div>
        <div class="p-4">
            <span>Volume :</span>
            <span>{{ $item->productVariant->volume ?? 'Volume inconnu'}}</span>
        </div>
        <div class="p-4">
            <span>Prix HT :</span>
            <span>{{ number_format($item->price_without_tax/100, 2, ',', '') ?? 'Prix erreur' }} €</span>
        </div>
        <div class="p-4">
            <span>Taxe :</span>
            <span>{{ $item->tax_amount ?? 'Taxe inconnue' }} %</span>
        </div>
        <div class="p-4">
            <span>Prix TTC :</span>
            <span>{{ number_format($item->priceWithTax()/100, 2, ',', '') ?? 'Prix erreur' }} €</span>

        </div>
        <form action="{{ route('order-items.update', $item->id) }}" method="POST">
            @csrf 
            @method('PATCH')
            <label for="quantity - {{ $item->id }}"> Quantité : </label>
            <input type="number" name="quantity" id="quantity - {{ $item->id }}" value="{{ $item->quantity ?? '1' }}" min="1" max="{{ $item->productVariant->stock_quantity }}" class="border">
            @error('quantity')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
        <hr>
    @endforeach
    <div class="p-4">
        <span>Prix HT (hors livraison)</span>
        <span>{{ number_format($order->total_price_without_tax/100, 2, ',', '') }} €</span>
    </div><div class="p-4">
        <span>(Taxe de</span>
        <span>{{ $order->items->pluck('tax_amount')->min() }} à {{ $order->items->pluck('tax_amount')->max() }} % selon les produits.)</span>
    </div>
    <div class="p-4">
        <span>Prix TTC (hors livraison)</span>
        <span>{{ number_format($order->total_price_with_tax/100, 2, ',', '') }} €</span>
    </div>
    {{-- <div class="p-4">
        <span>Frais de port</span>
        <span>{{ $shippingPrice }}</span>
    </div>
    <div class="p-4">
        <span>Prix total HT</span>
        <span>{{ $totalPriceWithoutTax + $shippingPrice }}</span>
    </div>
    <div class="p-4">
        <span>Prix total TTC</span>
        <span>{{ $totalPriceWithTax + $shippingPrice }}</span>
    </div> --}}

   <a class="to-checkout" href="{{ route('cart.checkout') }}">Commander</a>

</x-layout>