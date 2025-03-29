<x-layout title="Admin">
    <div class="container mx-auto">
        <h1>Tableau de bord administrateur</h1>
        <aside></aside>
        <div class="flex gap-0 bg-gray-700">
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
                <label for="all-products" class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">
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
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    <span>Nom :</span>
                    <span class="font-bold">{{ $product->name }}</span>
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
</x-layout>