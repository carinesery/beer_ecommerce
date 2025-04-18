<x-layout>
    <div class="flex flex-wrap gap-4 py-4 container mx-auto">
        <div> 
            <img src="{{ asset('storage/app/public/images/' . $product->image) }}" alt="Image du produit" class="w-100 h-100 border border-gray-400">
        </div>
        <div class="flex flex-col gap-4">
            <div>
                <span>Stock : {{ $productVariant->stock_quantity}}</span>
                <h1 class="font-bold text-3xl"><img src="{{ $product->brand->logo}}" alt="{{ $product->brand->name}}" class="w-20 h-20 border border-gray-400" > <span class="text-lg font-bold">{{ $product->brand->name}}</span></h1>
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
            <form action="{{ route('orderItems.store') }}" method="POST" class="flex flex-col flex-wrap gap-4 py-4 container mx-auto">
                @csrf
                @method('Post')
                <input type="hidden" name="product_variant_id" value="{{ $productVariant->id}}">
                @error('product_variant_id')                
                    <p>product_variant_id </p>
                @enderror
                <input type="hidden" name="price_without_tax" value="{{ $productVariant->price_without_tax }}">
                @error('total_price_without_tax')                
                    <p>price_without_tax</p>
                @enderror
                <input type="hidden" name="price_with_tax" value="{{ ($productVariant->price_without_tax)*($productVariant->tax_amount+100)/100 }}">
                @error('total_price_with_tax')                
                    <p>price_with_tax</p>
                @enderror
                <input type="hidden" name="tax_amount" value="{{ ($productVariant->tax_amount) }}">
                @error('tax_amount')                
                    <p>Error tax amout</p>
                @enderror
                <div>
                    <input type="number" name="quantity" id="quantity" min="0" max="{{ $productVariant->stock_quantity}}" value="0" class="px-2 py-1 border border-r-1 border-gray-400">
                    <button type="submit" class="border border-r-1 border-gray-400 py-1 px-3 text-white bg-orange-500 hover:bg-gray-500">Ajouter au panier !</button>
                </div>
            </form>
        </div >
    </div >
    
</x-layout>