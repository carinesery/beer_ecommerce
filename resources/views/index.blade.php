<x-layout title="Page d'accueil">
    <h1>Welcome</h1>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        @foreach ($users as $user)
                <span>{{ $user->firstname }}</span> <br>
        @endforeach
    </div>
</x-layout>