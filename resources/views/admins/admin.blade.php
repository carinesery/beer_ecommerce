<x-layout title="Admin">
    <div class="container mx-auto">
        <h1>Tableau de bord administrateur</h1>
        <div class="grid grid-cols-[10%_90%] ">
            <aside class="bg-gray-900 border-r-1 border-gray-400 p-4 text-white">
                <div class="mb-10">
                    <img src="#" alt="user">
                    <span>NomAdmin</span>
                </div >
                <div class="border-y-1">
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Création</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Client</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Vente</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Livraison</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Commande</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">NewsLetter</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Stoke</button>

                </div>
            </aside>
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
                    <div class="flex flex-col justify-between gap-3 border rounded p-4">
                        <div class="w-80">
                            <label for="{{ $product->id }}" class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">
                                <input type="checkbox" name="{{ $product->id }}" id="{{ $product->id }}">
                            </label>
                            <span>Stock : </span>
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <span>Nom :</span>
                            <span class="font-bold">{{ $product->name }}</span> <br>
                            <span>cl</span>
                            <span>{{ $product->alcohol_degree }} %</span> <br>
                            <span>Description :</span>
                            <span>{{ $product->description }}</span> <br>
                        </div>
                        <div class="flex gap-1">
                            <button class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">🖊️ modifier</button>
                            <button class="border rounded bg-red-700 py-1 px-3 text-white hover:bg-red-500">🗑️</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>