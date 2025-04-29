<style>
    .cancel-or-destroy {
        display: flex;
        column-gap: 2rem;
        width: 100%;
        align-items: center;
    }

    form {
        margin: 0;
    }
    
    .destroy-account,
    .cancel-destroy {
        padding: .75rem 1.5rem;
        border: 2px solid red;
        border-radius: .75rem;
        background-color: red;
        color: white;
        font-weight: 500;
    }

    .cancel-destroy {
        display: inline-block;
        width: fit-content;
        background-color: transparent;
        color: black;
        text-decoration: none;
        border-color: black;
    }

    .cancel-destroy:visited {
        color: black;
    }

    .destroy-account:hover {
        cursor: pointer;
    }

</style>
<x-layout title="Suppression du compte">
    <h1>Supression du compte</h1>
    <p>Etes-vous sûr(e) de vouloir supprimer votre compte ? <b>Cette action est définitive<b>.</p>
    <div class="cancel-or-destroy">
        <a class="cancel-destroy" href="{{ route('account.show') }}">Annuler</a>
        <form action="/auth/delete" method='POST'>
            @csrf 
            @method('DELETE')
            <button class="destroy-account" type=submit>Supprimer mon compte</button>
        </form>
    </div>
    
</x-layout>