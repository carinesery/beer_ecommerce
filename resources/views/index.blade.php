<x-layout title="E-commerce de bières">
    <div class="flex items-center justify-center py-20">
        <div class="max-w-xl bg-gray-100 border-1 border-gray-300 px-5 py-12 rounded">
            <form action="{{ route('login.authenticate') }}" method="post">
                @csrf
                <h1 class="text-2xl font-bold mb-5">Authentification</h1>
                <div>
                    <input type="email" name="email" id="email" placeholder="Email" class="mb-4 p-2 border border-gray-300 rounded bg-gray-50">
                    <br>
                    @error('email')
                        {{ $message }}
                    @enderror
                    <input type="password" name="password" id="password" placeholder="Mot de passe" class="mb-4 p-2 border border-gray-300 rounded bg-gray-50">
                    <br>
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Se connecter</button>
            </form>
        </div>
    </div>
</x-layout>