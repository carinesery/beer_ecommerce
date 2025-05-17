<style> 
    h1 {
        font-size: 2.5rem;
        text-align: center;
        margin: 1rem auto;
    }

    h2 {
        font-size: 1.6rem;
    }

    input, textarea {
        border: 1px solid grey;
    }

    form {
        width: 70%;
        margin: 1rem auto;
    }

    button {
        width: fit-content;
        padding: .5rem 1rem;
        border-radius: .5rem;
        display: block;
    }

    button[type=submit] {
        border: 2px solid blue;
        background-color: blue;
        color: white;
    }

    button[type=submit]:hover {
        background-color:rgb(0, 0, 255, .8);
    }

    button[type=button] {
        border: 2px solid blue;
        margin: 1rem;
    }

    .cancel-update {
        display: inline-block;
        width: fit-content;
        color: black;
        padding: .5rem 1rem;
        border: 2px solid black;
        border-radius: .5rem;
        font-weight: 500;
        text-decoration: none;
    }

    .buttons-action {
        margin-top: 2rem;
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 2rem;
    }

    .cancel-update:visited {
        color: black;
    }
</style>
<x-layout title="Modifier une variante">
    <h1>Modifier la variante {{ $productvariant->product->name }} {{ $productvariant->slug }}</h1>
    <form action="{{ route('productvariants.update', $productvariant) }}" method="POST">
        @csrf 
        @method('PATCH')
        <div>
            <label for="variant_slug">Slug de la variante</label>
            <input type="text" name="slug" id="variant_slug" value="{{ old('slug', $productvariant->slug) }}" required>
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="variant_volume">Volume</label>
            <input type="text" name="volume" id="variant_volume" value="{{ old('volume', $productvariant->volume) }}" required>
            @error('volume')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_stock_quantity">Quantité en stock</label>
            <input type="number" name="stock_quantity" id="variant_stock_quantity" value="{{ old('stock_quantity', $productvariant->stock_quantity) }}" required>
            @error('stock_quantity')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_price_without_tax">Prix HT</label>
            <input type="number" name="price_without_tax" id="variant_price_without_tax" value="{{ old('price_without_tax', $productvariant->price_without_tax) }}" required>
            @error('price_without_tax')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_tax_amount">Montant de la taxe</label>
            <input type="number" name="tax_amount" id="variant_tax_amount" value="{{ old('tax_amount', $productvariant->tax_amount) }}" required>
            @error('tax_amount')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_available">Disponible</label>
            <input type="hidden" name="available" value="0"> <!-- Si la checkbox n’est pas cochée, la valeur 0 est quand même envoyée -->
            <input type="checkbox" name="available" id="variant_available" value="1" {{ old('available', $productvariant->available ?? false) ? 'checked' : '' }}>
            @error('available')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="buttons-action">
            <a href="{{ route('admin.index') }}" class="cancel-update">Annuler</a>
            <button type="submit">Mettre à jour la variante</button>
        </div>
    </form>
</x-layout>