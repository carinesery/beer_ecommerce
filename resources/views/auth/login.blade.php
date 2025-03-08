<x-layout title="Connexion">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-xl bg-gray-100 borber-1 borber-gray-300 px-5 py-12 rounded">
            <form action="{{ route('login.authenticate') }}" method="post">
                @csrf
                <h1 class="text-2xl font-bold mb-5">Connexion</h1>
                <input type="email" name="email" id="email" placeholder="Email">
                @error('email')
                    {{ $message }}
                @enderror
                <input type="password" name="password" id="password" placeholder="Mot de passe">
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Se connecter</button>
            </form>
        </div>
    </div>
</x-layout>