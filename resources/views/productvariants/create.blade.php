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
        margin: 1rem auto;
    }

    button[type=submit]:hover {
        background-color:rgb(0, 0, 255, .8);
    }

    button[type=button] {
        border: 2px solid blue;
        margin: 1rem;
    }
</style>
<x-layout title="Ajouter une variante">
    <h1>Ajouter une variante au produit {{ $product->name }}</h1>
    <form action="{{ route('productvariants.store', $product) }}" method="POST">
        @csrf 
        <div>
            <label for="variant_slug">Slug de la variante</label>
            <input type="text" name="slug" id="variant_slug" value="{{ old('slug') }}" required>
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="variant_volume">Volume</label>
            <input type="text" name="volume" id="variant_volume" value="{{ old('volume') }}" required>
            @error('volume')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_stock_quantity">Quantité en stock</label>
            <input type="number" name="stock_quantity" id="variant_stock_quantity" value="{{ old('stock_quantity') }}" required>
            @error('stock_quantity')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_price_without_tax">Prix HT</label>
            <input type="number" name="price_without_tax" id="variant_price_without_tax" value="{{ old('price_without_tax') }}" required>
            @error('price_without_tax')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_tax_amount">Montant de la taxe</label>
            <input type="number" name="tax_amount" id="variant_tax_amount" value="{{ old('tax_amount') }}" required>
            @error('tax_amount')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="variant_available">Disponible</label>
            <input type="hidden" name="available" value="0"> <!-- Si la checkbox n’est pas cochée, la valeur 0 est quand même envoyée -->
            <input type="checkbox" name="available" id="variant_available" value="1" {{ old('available') ? 'checked' : '' }}>
            @error('available')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit">Créer la variante</button>
    </form>
</x-layout>