<x-layout title="Suppression du produit">
    <h1 class="text-4xl text-center my-10 font-bold mb-4">Suppression du produit <span class="text-blue-800">{{ $product->name }}</span></h1>
    <div class="flex flex-col gap-4 mx-auto my-10 border rounded-lg shadow-lg p-6 bg-white w-150">
        <p>Le produit <span class="text-blue-800">{{ $product->name }}</span> sera supprimé de la base de données.
            <br> 
            Cette action est définitive et entraînera la suppression de toutes les variantes associées à ce produit.
        </p>
        <div class="flex gap-4"> 
            <a href="{{ route('admin.index') }}" class="text-blue-600 hover:bg-blue-100 border border-blue-600 py-1 px-3 rounded">Annuler</a>
            <form action="{{ route('products.delete', $product) }}" method="POST">
                @csrf 
                @method('DELETE')
                <button type="submit" class="border rounded bg-red-600 py-1 px-3 text-white hover:bg-red-500 font-semibold">Supprimer le produit</button>
            </form>
        </div>
    </div>
</x-layout>