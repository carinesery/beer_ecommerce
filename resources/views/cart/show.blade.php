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

<x-layout>
    <h1>page panier</h1>
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
            <span>{{ $item->order->total_price_without_tax/100 ?? 'Prix erreur' }}</span>
        </div>
        <div class="p-4">
            <span>Prix TTC :</span>
            <span>{{ $item->order->total_price_with_tax/100 ?? 'Prix erreur' }}</span>

        </div>
        <div >
            <label for="number"> Quantité : </label>
            <input type="number" name="number" id="number" value="{{ $item->quantity ?? '1' }}" min="0" max="10" class="border">
        </div>
    </div>
        <hr>
    @endforeach
    {{-- <div class="p-4">
        <span>Prix HT</span>
        <span>{{ $totalPriceWithoutTax }}</span>
    </div>
    <div class="p-4">
        <span>Prix TTC</span>
        <span>{{ $totalPriceWithTax }}</span>
    </div>
    <div class="p-4">
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