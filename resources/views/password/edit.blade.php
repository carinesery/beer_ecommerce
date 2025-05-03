<style>
  .valid { color: green; }
  .invalid { color: red; }
  .required { color: red; }
</style>
<x-layout title="Modification du mot de passe">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-xl bg-gray-100 borber-1 borber-gray-300 px-5 py-12 rounded">
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                @method('PUT')
                <h1 class="text-2xl font-bold mb-5">Modification du mot de passe</h1>
                <div>
                    <label for="password">Ancien mot de passe<span class="required">*</span></label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for="password">Nouvveau mot de passe<span class="required">*</span></label>
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
                    <label for="password-confirmation">Confirmation du nouveau mot de passe<span class="required">*</span></label>
                    <input type="password" name="password_confirmation" id="password-confirmation" required>
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Confirmer mon nouveau mot de passe</button>
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
