<style>
  .valid { color: green; }
  .invalid { color: red; }
  .required { color: red; }
</style>
<x-layout title="Modification du compte">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-xl bg-gray-100 borber-1 borber-gray-300 px-5 py-12 rounded">
            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <h1 class="text-2xl font-bold mb-5">Modification du compte</h1>
                <div>
                    <label for="firstname">Prénom<span class="required">*</span></label>
                    <input type="text" name="firstname" id="firstname" placeholder="Ex : Bertrand" value="{{ old('firstname', $user->firstname) }}" required>
                    @error('firstname')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="lastname">Nom<span class="required">*</span></label>
                    <input type="text" name="lastname" id="lastname" placeholder="Ex : Lallemand" value="{{ old('lastname', $user->lastname) }}"required>
                    @error('lastname')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="birthdate">Date de naissance<span class="required">*</span></label>
                    <input type="date" name="birthdate" id="birthdate" placeholder="Ex : 25/04/2000" value="{{ old('birthdate', $user->birthdate) }}"required>
                    @error('birthdate')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="email">Email<span class="required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="Ex : bertrand.lallemand@gmail.com" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Confirmer la modification</button>
            </form>
            <p class="text-sm text-gray-600">Pour modifier votre mot de passe, <a href="{{ route('password.edit') }}" class="text-blue-500 underline">cliquez ici</a>.</p>
        </div>
    </div>
</x-layout>
