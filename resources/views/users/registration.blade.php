<x-layout title="Inscription">

    <form action="{{ route('users.store') }}" method="POST" class="flex flex-col justify-between gap-4 w-100 p-4">
        @csrf
        <div class="flex flex-col">
            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" class="border">
            @error('firstname')                
            <p>Error firstname</p>
            @enderror    
        </div>
        <div  class="flex flex-col">
            <label for="lastname">Nom :</label>
            <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" class="border">
            @error('lastname')            
            <p>Error lastname</p>
            @enderror 
        </div>
        <div class="flex flex-col">
            <label for="birthdate">Date de naissance :</label>
            <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="border">
            @error('birthdate')            
            <p>Error birthdate</p>
            @enderror  
        </div>
        <div class="flex flex-col">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="border">
            @error('email')            
            <p>Error email</p>
            @enderror 
        </div>
        <div class="flex flex-col">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" class="border">
            @error('password')            
            <p>Error password</p>
            @enderror 
        </div>
       <input type="text" name="role" value="customer">
       @error('role')            
        <p>Error role</p>
        @enderror 

        <button type="submit" class="border bg-gray-300 w-25">Envoyer</button>

    </form>

</x-layout>