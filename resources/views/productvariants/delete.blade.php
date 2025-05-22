<x-layout title="Suppression de la variante">
    <h1 class="text-4xl text-center my-10 font-bold mb-4">Supression de la variante <span class="text-blue-800">{{ $productvariant->product->name }}</span> <span class="text-blue-500">{{ $productvariant->slug }}</span></h1>
    <div class="flex flex-col gap-4 mx-auto my-10 border rounded-lg shadow-lg p-6 bg-white w-150">
        <p>Etes-vous sûr(e) de vouloir supprimer cette variante du produit {{ $productvariant->product->name }} ? 
            <br>
            <b>Cette action est définitive<b>.</p>
        <div class="flex gap-4">
            <a class="text-blue-600 hover:bg-blue-100 border border-blue-600 py-1 px-3 rounded" href="{{ route('admin.index') }}">Annuler</a>
            <form action="{{ route('productvariants.destroy', $productvariant) }}" method='POST'>
                @csrf 
                @method('DELETE')
                <button class="border rounded bg-red-600 py-1 px-3 text-white hover:bg-red-500 font-semibold" type=submit>Supprimer la variante</button>
            </form>
        </div>
    </div>
    
</x-layout>