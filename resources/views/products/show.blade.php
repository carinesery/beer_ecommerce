<x-layout>
    <div class="flex flex-wrap gap-4 py-4 container mx-auto border">
        <div> 
            <img src="{{ asset('storage/app/public/images/' . $product->image) }}" alt="Image du produit" class="w-100 h-100 border">
        </div>
        <div class="flex flex-col gap-4 border">
            <div>
                <span>Stock : {{ $productVariant->stock_quantity}}</span>
                <h1 class="font-bold text-3xl"><img src="{{ $product->brand->logo}}" alt="{{ $product->brand->name}}" class="w-20 h-20 border" > <span class="text-lg font-bold">{{ $product->brand->name}}</span></h1>
                <h2 class="font-bold text-3xl">{{ $product->name }} <span>{{ ($productVariant->price_without_tax/100)*($productVariant->tax_amount+100)/100}} €</span></h2>
                <span>{{ $productVariant->volume}}</span> <br> 
                <span>Degré d'alcool : {{ $product->alcohol_degree }} °C</span> <br>
                <span>Type de bière : {{ $product->category->name }}</span> <br>
            </div>
            <div>
                <h3>Description : </h3>
                <p>{{ $product->brand->description }}</p>
                <p>{{ $product->description }}</p>
            </div>
            <form action="" method="POST" class="flex flex-col flex-wrap gap-4 py-4 container mx-auto border">
                <input type="number" name="user_id" value="1">
                <input type="number" name="total_price_without_tax" value="{{ $productVariant->price_without_tax }}">
                <input type="number" name="total_price_with_tax" value="{{ ($productVariant->price_without_tax)*($productVariant->tax_amount+100)/100 }}">
                <input type="number" name="tax_amount" value="{{ ($productVariant->tax_amount) }}">
                <input type="text" name="status" value="cart">
                <div>
                    <input type="number" name="" id="" min="0" max="{{ $productVariant->stock_quantity}}" value="0" class="px-2 border">
                    <button type="submit" class="border px-3">Ajouter au panier !</button>
                </div>
            </form>
        </div >
    </div >
    
</x-layout>