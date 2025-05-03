<style>
    .infos-account {
        display: block;
    }

    .account-to-modify,
    .account-to-destroy {
        display: inline-block;
        width: fit-content;
        padding: .75rem 1.5rem;
        border: 2px solid red;
        border-radius: .75rem;
        text-decoration: none;
        color: red;
        font-weight: 500;
    }

    .account-to-modify:visited,
    .account-to-destroy:visited {
        color: red;
    }
</style>
<x-layout title="Mon compte">
    <h1>Mon compte</h1>
    <span class="infos-account">Prénom : {{ $user->firstname }}</span>
    <span class="infos-account">Nom : {{ $user->lastname }}</span>
    <span class="infos-account">Date de naissance : {{ $user->birthdate }}</span>
    <span class="infos-account">Email : {{ $user->email }}</span>

    <!-- Lien vers suppression de compte -->
    <a class="account-to-modify" href="{{ route('account.edit') }}">Modifier mon compte</a>
    <a class="account-to-destroy" href="{{ route('account.todestroy') }}">Supprimer mon compte</a>
</x-layout>