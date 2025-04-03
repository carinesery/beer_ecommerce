<x-layout :title="$user->firstname">
    <div class="container mx-auto">
       Role : {{ $user->role }} <br>
       Prénom : {{ $user->firstname }} {{ $user->lastname }} <br>
       Date : {{ $user->birthdate }} <br>
       Email : {{ $user->email }} <br>
    </div>
    <div>
        <a href="">Modifier</a>
        <a href="">Supprimer</a>

    </div>
</x-layout>