<x-layout title="Données">
    <h1 class="text-2xl font-bold mb-4">Données</h1>
    <form action="{{ route('admin.data.downloadDB') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Télécharger la base de données</button>
    </form>
</x-layout>