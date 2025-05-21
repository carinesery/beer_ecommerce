<x-layout title="Données">
    <h1 class="text-4xl text-center my-20 font-bold mb-4">Données</h1>
    <a href="{{ route('admin.index') }}" class="m-20 w-35 border rounded bg-black py-1 px-10 text-white hover:bg-gray-700"><span>Retour</span></a>

    <div class="m-20 border rounded-lg shadow-lg p-6 bg-white">
        <form action="{{ route('admin.data.downloadDB') }}" method="GET" class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Télécharger la base de données</button>
        </form>
        <div class="flex flex-row gap-10">
            <span> <span class="font-bold">Base de données</span> : beer_ecommerce</span>
            <span> <span class="font-bold">Serveur</span> : 127.0.0.1</span>
        </div>
    </div>

    <div class="m-20 border rounded-lg shadow-lg p-6 bg-white">
        <form action="" method="GET" class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Télécharger les statistiques</button>
        </form>
        <div class="max-w-4xl">
            <h2 class="text-2xl font-bold mb-4">Total des ventes</h2>
            <p class="text-lg">Total des ventes : {{ $totalSales ?: '0' }} €</p>
        </div>
        <div class="max-w-4xl mt-20">
            <h2 class="text-2xl font-bold mb-4">Total des ventes par mois</h2>
            @if($salesMonth->isEmpty())
            <p class="text-red-600">Aucune vente n'a été effectuée ce mois-ci.</p>
            @else
            <p class="text-lg">Mois : {{ $salesMonth->first()->mois ?: '0' }}</p>
            <p class="text-lg">Total des ventes par mois : {{ $salesMonth->sum('total') ?: '0' }} €</p>
            @foreach($salesMonth as $item)
            <p>Mois : {{ $item->mois ?: '' }} — Total : {{ $item->total ?: '0' }} €</p>
            @endforeach
            @endif
        </div>
    </div>

    <div class="m-20 border rounded-lg shadow-lg p-6 bg-white">
        <form action="" method="GET" class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Télécharger les statistiques</button>
        </form>
        <div class="max-w-4xl">
            <h2 class="text-2xl font-bold mb-4">Top 10 des meilleurs produits</h2>
            @if ($topProducts->isEmpty())
            <p class="text-red-600">Aucun produit n'a été vendu.</p>
            @else
            <ul>
                @foreach($topProducts as $produit)
                <li>{{ $produit->name }} - {{ $produit->total_vendus }} ventes</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <div class="m-20 border rounded-lg shadow-lg p-6 bg-white">
        <form action="" method="GET" class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Voir tous les produits</button>
        </form>
        <h2 class="text-2xl font-bold mb-4">Produits avec stock faible</h2>
        @if($lowStocks->isEmpty())
        <p class="text-green-600">Tous les stocks sont suffisants ✅</p>
        @else
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left">Nom du produit</th>
                    <th class="border p-2 text-left">Slug</th>
                    <th class="border p-2 text-right">Stock actuel</th>
                    <th class="border p-2 text-right"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStocks as $produitVariant)
                <tr class="hover:bg-red-50">
                    <td class="border p-2">{{ $produitVariant->product->name }}</td>
                    <td class="border p-2">{{ $produitVariant->slug }}</td>
                    <td class="border p-2 text-right text-red-600 font-semibold">
                        {{ $produitVariant->stock_quantity }}
                    </td>
                    <td class="border p-2 text-right text-600 font-semibold">
                        <a href="{{ route('productvariants.edit', $produitVariant->id) }}" class="bg-blue-500 text-white px-2 py-2 rounded">Détails</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="m-20 border rounded-lg shadow-lg p-6 bg-white">
        <form action="" method="GET" class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Télécharger les statistiques</button>
        </form>
        <h2 class="text-2xl font-bold mb-4">Statistiques de vente</h2>
        <div class="flex flex-row justify-center gap-10">
            <img src="{{ asset('images/tableau-statistique.png') }}" alt="Statistiques" class="border w-150">
            <img src="{{ asset('images/1323845.png') }}" alt="Statistiques" class="border w-150">
        </div>
        
    </div>

    </div>
    
</x-layout>