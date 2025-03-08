<x-layout title="Page d'accueil">
    <h1 class="py-3">Bienvenue @auth <b>{{ auth()->user()->firstname }}</b> 
    @endauth</h1>
    <div class="max-w-sm rounded overflow-hidden shadow-lg p-4 border-4 border-blue-400">
        <h2 class="p-8 text-center font-bold">Liste des Utilisateurs</h2>
        @foreach ($users as $user)
                <span>{{ $user->firstname }}</span> <br>
        @endforeach
    </div>
</x-layout>