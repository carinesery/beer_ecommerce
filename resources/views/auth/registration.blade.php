<x-layout title="Inscription">

    <form action="{{ route('register') }}" method="POST" class="flex flex-col justify-between gap-4 w-100 p-4">

        <div class="flex flex-col">
            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" class="border">
        </div>
        <div  class="flex flex-col">
            <label for="lastname">Nom :</label>
            <input type="text" name="lastname" id="lastname" class="border">
        </div>
        <div class="flex flex-col">
            <label for="date">Mot de passe :</label>
            <input type="date" name="date" id="date" class="border">
        </div>
        <div class="flex flex-col">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" class="border">
        </div>
        <div class="flex flex-col">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" class="border">
        </div>

        <button type="submit" class="border bg-gray-300 w-25">Envoyer</button>

    </form>

</x-layout>