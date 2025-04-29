<style>
  .valid { color: green; }
  .invalid { color: red; }
  .required { color: red; }
</style>
<x-layout title="Inscription">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-xl bg-gray-100 borber-1 borber-gray-300 px-5 py-12 rounded">
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <h1 class="text-2xl font-bold mb-5">Création d'un compte</h1>
                <div>
                    <label for="firstname">Prénom<span class="required">*</span></label>
                    <input type="text" name="firstname" id="firstname" placeholder="Ex : Bertrand" value="{{ old('firstname') }}" required>
                    @error('firstname')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="lastname">Nom<span class="required">*</span></label>
                    <input type="text" name="lastname" id="lastname" placeholder="Ex : Lallemand" value="{{ old('lastname') }}"required>
                    @error('lastname')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="birthdate">Date de naissance<span class="required">*</span></label>
                    <input type="date" name="birthdate" id="birthdate" placeholder="Ex : 25/04/2000" value="{{ old('birthdate') }}"required>
                    @error('birthdate')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="email">Email<span class="required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="Ex : bertrand.lallemand@gmail.com" value="{{ old('email') }}" required>
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="password">Mot de passe<span class="required">*</span></label>
                    <input type="password" name="password" id="password" oninput="checkPassword(this.value)" required>
                    @error('password')
                        {{ $message }}
                    @enderror
                    <ul id="password-rules">
                        <li id="length" class="invalid">✔️ 8 caractères minimum</li>
                        <li id="lowercase" class="invalid">✔️ Une minuscule</li>
                        <li id="uppercase" class="invalid">✔️ Une majuscule</li>
                        <li id="number" class="invalid">✔️ Un chiffre</li>
                        <li id="special" class="invalid">✔️ Un caractère spécial</li>
                    </ul>
                </div>
                <div>
                    <label for="password-confirmation">Confirmation du mot de passe<span class="required">*</span></label>
                    <input type="password" name="password_confirmation" id="password-confirmation" required>
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <input type="checkbox" name="privacy_policy" id="privacy-policy" {{ old('privacy_policy') ? 'checked' : '' }} required>
                    <label for="privacy-policy">En cochant cette case, j'accepte la <a href="">Politique de confidentialité</a>.<span class="required">*</span></label>
                    @error('privacy_policy')
                        {{ $message }}
                    @enderror 
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Créer mon compte</button>
            </form>
        </div>
    </div>
</x-layout>
<script>
    function checkPassword(password) {
        document.getElementById('length').className = password.length >= 8 ? 'valid' : 'invalid';
        document.getElementById('lowercase').className = /[a-z]/.test(password) ? 'valid' : 'invalid';
        document.getElementById('uppercase').className = /[A-Z]/.test(password) ? 'valid' : 'invalid';
        document.getElementById('number').className = /\d/.test(password) ? 'valid' : 'invalid';
        document.getElementById('special').className = /[^a-zA-Z\d]/.test(password) ? 'valid' : 'invalid';
    }
</script>
