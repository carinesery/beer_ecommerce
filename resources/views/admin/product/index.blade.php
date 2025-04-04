<x-layout title="Admin">
    <div class="container mx-auto">
        <h1>Tableau de bord administrateur</h1>
        <div class="grid grid-cols-[10%_90%] ">
            <x-filterAdmin></x-filterAdmin>
            <div>
                <div class="flex justify-between gap-0 bg-gray-700">
                    <div class="flex gap-0">
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Nom</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Alcool</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Volume</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Stock</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Prix</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Disponible</button>
                        <label for="search" class="bg-gray-600 border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500"> 🔎
                            <input type="search" name="search" id="search" placeholder="Rechercher" >
                        </label>
                    </div>
                    <div>
                        <label for="all-products" class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Tout
                            <input type="checkbox" name="all-products" id="all-products">
                        </label>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">🗑️ Corbeille</button>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 bg-gray-200 p-4 ">
                @foreach ($products as $product)
            <div class="grid text-center grid-cols-4 gap-4">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit"><br>    
                    <h2>{{ $product->name }}</h2> 
                    <span>{{ $product->slug }}</span><br> <!-- Uniquement pour test -->
                    <span>
                        {{ $product->brand ? $product->brand->name : 'Aucune marque' }}
                    </span><br>
                    <span class="inline-block bg-amber-100 rounded-xl px-3 py-1 text-sm">
                        {{ $product->category ? $product->category->name : 'Aucune catégorie'}}
                    </span><br>
                    <!-- @foreach ($product->productVariants as $variant)
                        <span>A partir de {{ $variant->price_without_tax/100 }} €</span><br>
                    @endforeach -->
                    <span>
                        A partir de {{ $variant->price_without_tax/100 }} €
                    </span><br>
                    <a href="{{ route('products.show', ['product' => $product->slug]) }}" class="inline-block bg-blue-100 rounded-xl px-3 py-1 text-sm">
                        Voir le produit
                    </a>
                    <a href="{{ route('products.edit', ['product' => $product]) }}" class="inline-block bg-blue-100 rounded-xl px-3 py-1 text-sm">
                        Modifier le produit
                    </a>
                </div>
            </div>        
        @endforeach
                    <!-- @foreach ($products as $product)
                    <div class="flex flex-col justify-between gap-3 border rounded p-4">
                        <div class="w-80">
                            <div class="flex justify-between">
                                <label for="{{ $variant->product->id }}" class="py-1">
                                    <input type="checkbox" name="{{ $variant->product->id }}" id="{{ $variant->product->id }}">
                                </label>
                                <span>Stock : {{ $variant->stock_quantity }}</span>
                            </div>
                            <img src="{{ $variant->product->image }}" alt="{{ $variant->product->name }}">
                            <span>Nom :</span>
                            <span class="font-bold">{{ $variant->product->name }}</span> <br>
                            <span>{{ $variant->volume }}</span>
                            <span>{{ $variant->product->alcohol_degree }} %</span> <br>
                            <span>Description :</span>
                            <span>{{ $variant->product->description }}</span> <br>
                        </div>
                        <div class="flex gap-1">
                        <a href="{{ route('products.edit', $product) }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">🖊️ modifier</a>
                            <button class="border rounded bg-red-700 py-1 px-3 text-white hover:bg-red-500">🗑️</button>
                        </div>
                    </div>
                    @endforeach -->
                </div>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>