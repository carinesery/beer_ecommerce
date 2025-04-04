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
                    <div class="flex items-center gap-1 ">
                        <a href="{{ route('users.create') }}" class=" border-r-1 border-gray-400 py-1 px-3 hover:bg-gray-500">
                            </span class="">
                                <svg height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M720-400v-120H600v-80h120v-120h80v120h120v80H800v120h-80Zm-360-80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z"/></svg>
                            </span>
                        </a>
                        <label for="all-products" class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">Tout
                            <input type="checkbox" name="all-products" id="all-products">
                        </label>
                        <button class="border-r-1 border-gray-400 py-1 px-3 text-white hover:bg-gray-500">🗑️ Corbeille</button>
                    </div>
                </div>
                <div class="flex flex-wrap bg-gray-200 gap-4 p-4 ">
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
                            <a href="{{ route('users.edit', $user) }}" class="flex items-center justify-center border rounded bg-black py-1 px-3 text-white hover:bg-gray-700">🖊️ modifier</a>
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