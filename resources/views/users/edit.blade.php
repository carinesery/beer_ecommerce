<x-layout title="Admin">
    <div class="flex flex-col gap-10 container mx-auto my-4">
        <div>
            <a href="{{ route('users') }}" class=" border rounded bg-black px-2 py-1 text-white hover:bg-gray-700"><span>📋</span></a>
            <a href="{{ route('users.show', $user) }}" class=" border rounded bg-black py-1 px-10 text-white hover:bg-gray-700"><span>Retour</span></a>
        </div>

        
        <form action="{{ route('users.update', $user) }}" method="POST" class="w-100">        
            @csrf      
            <div class="flex flex-col">
                <label for="firstname">Prénom :</label>
                <input type="text" name="firstname" id="firstname" value="{{ old('firstname') ?? $user->firstname}}" class="border">
                @error('firstname')                
                <p>Error firstname</p>
                @enderror    
            </div>
            <div  class="flex flex-col">
                <label for="lastname">Nom :</label>
                <input type="text" name="lastname" id="lastname" value="{{ old('lastname') ?? $user->lastname}}"  class="border">
                @error('lastname')            
                <p>Error lastname</p>
                @enderror 
            </div>
            <div class="flex flex-col">
                <label for="birthdate">Date de naissance :</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') ?? $user->birthdate}}" class="border">
                @error('birthdate')            
                <p>Error birthdate</p>
                @enderror  
            </div>
            <div class="flex flex-col">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" value="{{ old('email') ?? $user->email }}" class="border">
                @error('email')            
                <p>Error email</p>
                @enderror 
            </div>
            <div class="flex flex-col">
                <label for="role">Rôle :</label>
                <input type="text" name="role" value="{{ old('role') ?? $user->role }}" class="border">
           @error('role')            
            <p>Error role</p>
            @enderror
            {{-- <select id="role" name="role" required>
                @foreach(\App\Models\User::ROLES as $role)
                    <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>  --}}
            </div>
           
            <button type="submit" class="border rounded bg-black my-4 py-1 px-10 text-white hover:bg-gray-700">Enregistrer</button>    
        </form>
        <div class="container mx-auto">
            <span>Date de création de compte : {{ $user->created_at }} </span><br>
            <span>Mise à jour du compte : {{ $user->updated_at }} </span>
        </div>
    </div>
</x-layout>