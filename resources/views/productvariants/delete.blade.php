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
    
    .destroy-variant,
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

    .destroy-variant:hover {
        cursor: pointer;
    }

</style>
<x-layout title="Suppression de la variante">
    <h1>Supression de la variante {{ $productvariant->product->name }} {{ $productvariant->slug }}</h1>
    <p>Etes-vous sûr(e) de vouloir supprimer cette variante du produit {{ $productvariant->product->name }} ? <b>Cette action est définitive<b>.</p>
    <div class="cancel-or-destroy">
        <a class="cancel-destroy" href="{{ route('admin.index') }}">Annuler</a>
        <form action="{{ route('productvariants.destroy', $productvariant) }}" method='POST'>
            @csrf 
            @method('DELETE')
            <button class="destroy-variant" type=submit>Supprimer la variante</button>
        </form>
    </div>
    
</x-layout>