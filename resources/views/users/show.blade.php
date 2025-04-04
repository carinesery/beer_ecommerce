<x-layout title="Admin">
    <div class="flex flex-col gap-10 container mx-auto my-4">
        <a href="{{ route('users') }}" class="w-35 border rounded bg-black py-1 px-10 text-white hover:bg-gray-700"><span>Retour</span></a>
        <div class="container mx-auto">
            <h1 class="font-bold text-xl text-lg">{{ $user->firstname }} {{ $user->lastname }} </h1><br>
            <span>Date de création de compte : {{ $user->created_at }} </span><br>
            <span>Mise à jour du compte : {{ $user->updated_at }} </span><br>
            <span>Rôle : {{ $user->role }} </span><br>
           <span>Date de naissance : {{ $user->birthdate }} </span><br>
           <span>Email : {{ $user->email }} </span><br>
        </div>
        <div class="container mx-auto">
           <h2 class="font-bold text">Historique des achats</h2>
           <div class="font-light text-s">Rien pour le moment...</div>
        </div>
        <div class="flex gap-4 container mx-auto">
            <a href="{{ route('users.edit', $user) }}" class="border rounded bg-black py-1 px-10 text-white hover:bg-gray-700"><span class="">Modifier</span></a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" >
                @csrf
                @method('DELETE')
                <button type="submit" class="border rounded bg-red-500 py-1 px-10 text-white hover:bg-red-700">Supprimer</button>
            </form>
        </div>
    </div>
    
</x-layout>