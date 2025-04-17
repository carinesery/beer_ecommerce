<x-layout>
    <h1>page panier</h1>
    @foreach ($orders as $order)

        <div class="grid items-center grid-cols-[_100px_repeat(5,_minmax(100px,_1fr))] gap-1 bg-gray-200 ">
            <div class="p-4">
                <img src="" alt="image produit">
            </div>
            <div class="p-4">
                <span>Nom du produit</span>
            </div>
            <div class="p-4">
                <span>Nom variant</span>
                <span>{{ $order->total_price_with_tax }}</span>
s
                

                
            </div>
        
    @endforeach
    @foreach ($orderItems as $item)
        <span>{{ $item->order_id }}</span>
    @endforeach

    <?php dd($user->id); ?>
    <div class="grid items-center grid-cols-[_100px_repeat(5,_minmax(100px,_1fr))] gap-1 bg-gray-200 ">
        <div class="p-4">
            <img src="" alt="image produit">
        </div>
        <div class="p-4">
            <span>Nom du produit</span>
        </div>
        <div class="p-4">
            <span>Nom variant</span>
            <span> {{ $orders->variant_name }}</span>
        </div>
            <span> {{ $orders->status }}</span>

        </div>
        <div class="p-4">
            <span>Prix</span>
        </div>
        <div class="p-4">
            <span>Disponible</span>
        </div>
        <div >
            <label for="number"> Quantité : </label>
                <input type="number" name="number" id="number" value="0" min="0" max="10" class="border">
        </div>
      </div>
   
</x-layout>