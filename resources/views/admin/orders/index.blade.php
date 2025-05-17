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
                    <h2>Liste des commandes</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Utilisateur</th>
                                    <th>Statut</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                                    <td>{{ $order->getStatusLabel() }}</td>
                                    <td>{{ number_format($order->total_price_with_tax / 100, 2, ',', '') }} €</td>
                                    <td>
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