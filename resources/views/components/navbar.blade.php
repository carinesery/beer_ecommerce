<nav class="bg-gray-800">
    @auth
    <form action="{{ route('logout') }}" method="POST" class="rounded-md px-3 py-2 text-sm font-medium text-white">
    <!---- le csrf validation du formulaire de par la personne ------>
        @csrf 
        <button type="submit">Déconnexion</button>
    </form>
    {{-- <a href="{{ route('logi') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white">Login</a>                         --}}

        @else
    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white">Connexion</a>                    

    @endauth
</nav>