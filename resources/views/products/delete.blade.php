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
    
    .destroy-product,
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

    .destroy-product:hover {
        cursor: pointer;
    }

    h1 {
        font-weight: 600;
        font-size: 2rem;
    }
</style>
<x-layout title="Suppression du produit">
    <h1>Suppression du produit {{ $product->name }}</h1>
    <p>Etes-vous sûr(e) de vouloir supprimer ce produit ? Cette action entraînera également la suppression des variations du produit et <b>est définitive</b>.</p>  
    <div class="cancel-or-destroy"> 
        <a href="{{ route('admin.index') }}" class="cancel-destroy">Annuler</a>
        <form action="{{ route('products.delete', $product) }}" method="POST">
            @csrf 
            @method('DELETE')
        <button type="submit" class="destroy-product">Supprimer le produit</button>
    </form>
    </div>
</x-layout>