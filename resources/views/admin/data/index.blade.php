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
        <h2>Statistiques de vente</h2>
        <div class="flex flex-row gap-10">
            <img src="{{ asset('images/tableau-statistique.png') }}" alt="Tableau des statistiques" class="border w-200">
            <img src="{{ asset('images/1323845.png') }}" alt="Tableau des statistiques" class="border w-200">

        </div>
    </div>
    
</x-layout>