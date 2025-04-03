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
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Produits</button>
                    <hr>
                    <button class="w-24 py-1 text-white hover:bg-gray-500">Clients</button>
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
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Admin</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Costumer</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Prénom</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Nom</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Email</button>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Date de naissance</button>
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
                    @foreach ($users as $user)
                    <div class="flex flex-col justify-between gap-3 border rounded p-4">
                        <div class="w-80">
                            <div class="flex justify-between">
                                <label for="{{ $user->firstname }}" class="py-1">
                                    <input type="checkbox" name="{{ $user->firstname }}" id="{{ $user->firstname }}">
                                </label>
                                <span>Rôle : {{ $user->role }} </span>
                            </div>
                            <span>Prénom : {{ $user->firstname }}</span><br>
                            <span>Nom : {{ $user->lastname }}</span><br>
                            <span> Email : {{ $user->firstname }}</span><br>
                            <span>Date d'anniversaire : {{ $user->birthdate }}</span>
                        </div>
                        <div class="flex gap-1">
                            <button class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">🖊️ modifier</button>
                            <button class="border rounded bg-red-700 py-1 px-3 text-white hover:bg-red-500">🗑️</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>