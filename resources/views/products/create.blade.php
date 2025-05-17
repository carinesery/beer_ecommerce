<x-layout title="Ajouter un produit">
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

    <h1>Ajouter un produit</h1>
    <form action="{{ route('products.store') }}" enctype="multipart/form-data" method="post">
    @csrf <!-- Token pour vérifier que la requête est légitime et provient de l'application -->
        <h2>Produit</h2>
        <div>
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required>
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="name">Nom du produit</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" required>{{ old('description') }}</textarea>
            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="alcohol_degree">Degré d'alcool</label>
            <input type="number" name="alcohol_degree" id="alcohol_degree" value="{{ old('alcohol_degree') }}" required>
            @error('alcohol_degree')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label>Catégorie</label>
            <div>
                @foreach($categories as $category)
                    <label>
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                            {{ old('category_id') == $category->id ? 'checked' : '' }} required>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('category_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sélectionner une marque existante -->
        <div>
            <label for="brand_id">Marque</label>
            <select name="brand_id" id="brand_id">
                <option value="">Sélectionnez une marque</option> <!-- Option vide pour forcer l'utilisateur à sélectionner une marque -->
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>

            @error('brand_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Ou saisir une nouvelle marque -->
        <div>
            <label for="new_brand">Nouvelle marque (si pas trouvée dans la liste)</label>
            <input type="text" name="new_brand" id="new_brand" value="{{ old('new_brand') }}">
            @error('new_brand')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

         <!-- Champ pour la description de la nouvelle marque -->
         <div>
            <label for="new_brand_description">Description de la nouvelle marque</label>
            <textarea name="new_brand_description" id="new_brand_description">{{ old('new_brand_description') }}</textarea>
            @error('new_brand_description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Champ pour télécharger le logo de la nouvelle marque -->
        <div>
            <label for="new_brand_logo">Logo de la nouvelle marque</label>
            <input type="file" name="new_brand_logo" id="new_brand_logo" accept="image/*">
            @error('new_brand_logo')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Partie Variantes -->
        <h2>Variante(s)</h2>

        <div id="variants">
            <div class="variant">
                <div>
                    <label for="variant_slug">Slug de la variante</label>
                    <input type="text" name="variants[0][slug]" id="variant_slug" value="{{ old('variants.0.slug') }}" required>
                    @error('variants.0.slug')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_volume">Volume</label>
                    <input type="text" name="variants[0][volume]" id="variant_volume" value="{{ old('variants.0.volume') }}" required>
                    @error('variants.0.volume')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_stock_quantity">Quantité en stock</label>
                    <input type="number" name="variants[0][stock_quantity]" id="variant_stock_quantity" value="{{ old('variants.0.stock_quantity') }}" required>
                    @error('variants.0.stock_quantity')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_price_without_tax">Prix HT (en centimes)</label>
                    <input type="number" name="variants[0][price_without_tax]" id="variant_price_without_tax" value="{{ old('variants.0.price_without_tax') }}" required>
                    @error('variants.0.price_without_tax')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_tax_amount">Montant de la taxe</label>
                    <input type="number" name="variants[0][tax_amount]" id="variant_tax_amount" value="{{ old('variants.0.tax_amount') }}" required>
                    @error('variants.0.tax_amount')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_available">Disponible</label>
                    <input type="checkbox" name="variants[0][available]" id="variant_available" value="1" {{ old('variants.0.available') ? 'checked' : '' }}>
                    @error('variants.0.available')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <button type="button" id="add_variant">Ajouter une variante</button>

        <button type="submit">Créer le produit</button>

    </form>
    <a href="{{ route('admin.index') }}">Retour</a>
</x-layout>