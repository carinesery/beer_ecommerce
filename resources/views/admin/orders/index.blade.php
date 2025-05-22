<x-layout title="Toutes les commandes des clients">
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
                <div >
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
                    <h2 class="font-bold text-xl mb-4 text-center p-10">Liste des commandes</h2>
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-200 text-gray-700 font-bold">
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2">ID</th>
                                    <th class="border border-gray-300 px-4 py-2">Utilisateur</th>
                                    <th class="border border-gray-300 px-4 py-2">Statut</th>
                                    <th class="border border-gray-300 px-4 py-2">Total</th>
                                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-gray-700">
                                @foreach($orders as $order)
                                <tr class="border-b border-gray-300">
                                    <td class="border border-gray-300 px-4 py-2">#{{ $order->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $order->getStatusLabel() }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ number_format($order->total_price_with_tax / 100, 2, ',', '') }} €</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if($order->status !== 'cancelled')
                                        <form method="POST" action="{{ route('admin-orders.cancel', $order->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Annuler la commande</button>
                                        </form>
                                        @else
                                            Annulée le {{ $order->cancelled_at ? $order->cancelled_at->format('d-m-Y à H:i') : '(date inconnue)' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
</x-layout>