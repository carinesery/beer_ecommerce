<x-layout title="Modifier une variante">
    <h1 class="text-4xl text-center my-10 font-bold mb-4">Modifier la variante <span class="text-blue-800">{{ $productvariant->product->name }} 
        </span><span class="text-blue-500">{{ $productvariant->slug }}</span></h1>
    <a href="{{ url()->previous() }}" class="inline-block mb-4 text-blue-600 hover:bg-blue-100 border border-blue-600 p-2 m-2 rounded">Retour</a>
    <form action="{{ route('productvariants.update', $productvariant) }}" method="POST" class="mx-auto my-10 border rounded-lg shadow-lg p-6 bg-white flex flex-col gap-4 w-150">
        @csrf 
        @method('PATCH')
        <div class="flex flex-col gap-4">
            <label for="variant_slug">Slug de la variante :</label>
            <input type="text" name="slug" id="variant_slug" value="{{ old('slug', $productvariant->slug) }}" required
            class="border-2 border-gray-300 rounded w-100">
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col gap-4">
            <label for="variant_volume">Volume :</label>
            <input type="text" name="volume" id="variant_volume" value="{{ old('volume', $productvariant->volume) }}" required
            class="border-2 border-gray-300 rounded w-100">
            @error('volume')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <label for="variant_stock_quantity">Quantité en stock :</label>
            <input type="number" name="stock_quantity" id="variant_stock_quantity" value="{{ old('stock_quantity', $productvariant->stock_quantity) }}" required
            class="border-2 border-gray-300 rounded w-100">
            @error('stock_quantity')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <label for="variant_price_without_tax">Prix HT :</label>
            <input type="number" name="price_without_tax" id="variant_price_without_tax" value="{{ old('price_without_tax', $productvariant->price_without_tax) }}" required
            class="border-2 border-gray-300 rounded w-100">
            @error('price_without_tax')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <label for="variant_tax_amount">Montant de la taxe :</label>
            <input type="number" name="tax_amount" id="variant_tax_amount" value="{{ old('tax_amount', $productvariant->tax_amount) }}" required
            class="border-2 border-gray-300 rounded w-100">
            @error('tax_amount')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <label for="variant_available">Disponible</label>
            <input type="hidden" name="available" value="0"> <!-- Si la checkbox n’est pas cochée, la valeur 0 est quand même envoyée -->
            <input type="checkbox" name="available" id="variant_available" value="1" {{ old('available', $productvariant->available ?? false) ? 'checked' : '' }}>
            @error('available')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4 mt-4">
            <a href="{{ route('admin.index') }}" class="text-blue-600 hover:bg-blue-100 border border-blue-600 py-1 px-3 rounded">Annuler</a>
            <button type="submit" class="border rounded bg-blue-700 py-1 px-3 text-white hover:bg-blue-500">Mettre à jour la variante</button>
        </div>
    </form>
</x-layout>