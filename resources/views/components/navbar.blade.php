<nav class="bg-gray-800 flex items-center justify-between px-4 py-2">
    <div class="flex items-center justify-center space-x-4 text-white">
        <img src="{{ asset('images/logo-trink.svg') }}" alt="Logo" class="h-16 w-16">
        <span class="py-3 mb-4">Bienvenue @auth<b>{{ auth()->user()->firstname }}</b>@endauth.</span>
        @auth<span class="py-3 mb-4">Rôle : <b>{{ auth()->user()->role }}</b></span>@endauth
    </div>
    
    @auth
    <form action="{{ route('logout') }}" method="POST" class="rounded-md px-3 py-2 text-sm font-medium text-white border border-white">
        <!---- le csrf validation du formulaire de par la personne ------>
        @csrf 
        <button type="submit">Déconnexion</button>
    </form>

        @else
    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white border border-white">Connexion</a>

    @endauth
</nav>