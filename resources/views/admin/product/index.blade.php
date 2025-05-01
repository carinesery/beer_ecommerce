<style>
    .add-product {
       padding: .5rem 1rem;
    }
</style>
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
                <div class="add-product">
                    <a href="{{ route('products.create') }}" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">Créer un nouveau produit</a>
                </div>
                <div class="flex flex-wrap justify-between gap-3 border rounded p-4"> <!-- flex-row  -->
                    @foreach ($products as $product)
                        <div class="flex flex-col  w-full justify-between gap-3 border rounded p-4">
                            <div> <!-- class="w-80" -->
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"><br>    
                                <h2 class="font-bold">{{ $product->name }}</h2> 
                                <span>
                                    {{ $product->brand ? $product->brand->name : 'Aucune marque' }}
                                </span><br>
                                <span class="inline-block bg-amber-100 rounded-xl px-3 py-1 text-sm">
                                    {{ $product->category ? $product->category->name : 'Aucune catégorie'}}
                                </span><br>
                                <div class="mt-4">
                                    <h3 class="font-medium text-lg">Variantes :</h3>
                                    @if ($product->productVariants->isEmpty())
                                        <p class="text-gray-500">Aucune variante.</p>
                                    @else
                                        <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <th>Contenance</th>
                                                    <th>Stock</th>
                                                    <th>Prix HT</th>
                                                    <th>Taxe</th>
                                                    <th>Prix TTC</th>
                                                    <th>Actions</th>
                                                </tr>    
                                            </thead>
                                            <tbody>
                                                @foreach ($product->productVariants as $productvariant)
                                                <tr>
                                                    <td>{{ $productvariant->volume }}</td>
                                                    <td>{{ $productvariant->stock_quantity }}</td>
                                                    <td>{{ $productvariant->price_without_tax }}</td>
                                                    <td>{{ $productvariant->tax_amount }}</td>
                                                    <td>{{ 'A créer' }}</td>
                                                    <td><!-- Actions -->
                                                        <a href="{{ route('productvariants.edit', $productvariant) }}">Modifier la variante</a>
                                                        <a href="{{ route('productvariants.todestroy', $productvariant) }}">Supprimer la variante</a>
                                                    </td>
                                                        <!-- <p>Contenance : {{ $productvariant->volume }} – Stock : {{ $productvariant->stock_quantity }}</p>
                                                    </li> -->
                                                </tr>
                                                @endforeach
                                            </tbody>  
                                            <tfoot>
                                                <th>
                                                    <a href="{{ route('productvariants.create', $product) }}">Ajouter une variante</a>
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