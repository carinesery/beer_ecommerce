<x-layout title="Admin">
    <div class="container mx-auto">
        <h1>Tableau de bord administrateur</h1>
        <div class="grid grid-cols-[10%_90%] ">
            <x-filterAdmin></x-filterAdmin>
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
                            <a href="{{ route('users.show', $user) }}" class="flex items-center justify-center border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">👁️ détail</a>
                            <a href="#" class="flex items-center justify-center border rounded bg-black py-1 px-3 text-white hover:bg-gray-700">🖊️ modifier</a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block bg-red-500 rounded px-3 py-3 text-sm hover:bg-red-700">🗑️</button>
                            </form>
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