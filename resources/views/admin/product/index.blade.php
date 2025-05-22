<x-layout title="Admin">
    <div class="container mx-auto">
        <h1>Tableau de bord administrateur</h1>
        <!-- Affichage du message de succès -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-[10%_90%] ">
            <x-filterAdmin></x-filterAdmin>
            <div class="flex flex-col gap-3">
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
                <a href="{{ route('products.create') }}" class="border rounded bg-blue-700 py-1 px-3 text-center text-white hover:bg-blue-500 m-4 w-55">
                    Créer un nouveau produit
                </a>
                <div class="flex flex-wrap justify-between gap-3 p-4">
                    @foreach ($products as $product)
                    <div class="flex flex-col  w-full justify-between gap-3 border rounded p-4">
                        <div>
                            <div class="flex gap-3 justify-between">
                                <div class="flex gap-3">
                                    <div class="flex justify-center flex-col">
                                        <h2 class="font-bold text-4xl">{{ $product->name }}</h2>
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover border border-gray-300 rounded"><br>   
                                    </div>
                                    <span class="inline-block">
                                       <b>Marque :</b>
                                        {{ $product->brand ? $product->brand->name : 'Aucune marque' }}
                                    </span><br>
                                    <span class="inline-block rounded-xl px-3 py-1 text-sm">
                                        <b>Type :</b>
                                        {{ $product->category ? $product->category->name : 'Aucune catégorie'}}
                                    </span>
                                </div>
                                <a href="{{ route('productvariants.create', $product) }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500 self-start">Ajouter une variante</a>
                            </div>
                            
                            <div class="mt-4">
                                @if ($product->productVariants->isEmpty())
                                    <p class="text-gray-500">Aucune variante.</p>
                                @else
                                <table class="w-full border-collapse border border-gray-300 my-4">
                                        <caption class="text-center text-lg font-bold mb-2">Liste des variantes</caption>
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="p-2 text-center">Contenance</th>
                                                <th class="p-2 text-center">Stock</th>
                                                <th class="p-2 text-center">Prix HT</th>
                                                <th class="p-2 text-center">Taxe (%)</th>
                                                <th class="p-2 text-center">Prix TTC</th>
                                                <th class="p-2 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->productVariants as $productvariant)
                                            <tr class="border-b">
                                                <td class="p-2 text-center">{{ $productvariant->volume }}</td>
                                                <td class="p-2 text-center">{{ $productvariant->stock_quantity }}</td>
                                                <td class="p-2 text-center">{{ number_format($productvariant->price_without_tax/100, 2, ',', '') }}</td>
                                                <td class="p-2 text-center">{{ $productvariant->tax_amount }}</td>
                                                <td class="p-2 text-center">{{ number_format($productvariant->productVariantPriceWithTax()/100, 2, ',','') }}</td>
                                                <td><!-- Actions -->
                                                    <a href="{{ route('productvariants.edit', $productvariant) }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">Modifier la variante</a>
                                                    <a href="{{ route('productvariants.todestroy', $productvariant) }}" class="border rounded bg-red-700 py-1 px-3 text-white hover:bg-red-500">Supprimer la variante</a>
                                                </td>
                                                    <!-- <p>Contenance : {{ $productvariant->volume }} – Stock : {{ $productvariant->stock_quantity }}</p>
                                                </li> -->
                                            </tr>
                                            @endforeach
                                        </tbody>  
                                        <tfoot>
                                            <th>
                                            </th>
                                        </tfoot> 
                                    </table>
                                @endif
                            </div>
                            <div class="flex gap-1">
                                <a href="{{ route('products.show', ['product' => $product->slug]) }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">
                                    👁️ Voir le produit
                                </a>
                                <a href="{{ route('products.edit', ['product' => $product]) }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">
                                    🖊️ Modifier le produit
                                </a>
                                <a href="{{ route('products.delete', $product) }}" class="border rounded bg-red-700 py-1 px-3 text-white hover:bg-red-500">🗑️ Supprimer</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                    
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>