<x-layout title="Modifier un produit">
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

    <h1>Modifier le produit {{ $product->name }}</h1>
    
    <form action="{{ route('products.update', $product) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT') <!-- Indique que c'est une requête PUT pour la mise à jour -->
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <h2>Produit</h2>
        
        <!-- Slug -->
        <div>
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required>
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Nom du produit -->
        <div>
            <label for="name">Nom du produit</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Description -->
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Degré d'alcool -->
        <div>
            <label for="alcohol_degree">Degré d'alcool</label>
            <input type="number" name="alcohol_degree" id="alcohol_degree" value="{{ old('alcohol_degree', $product->alcohol_degree) }}" required>
            @error('alcohol_degree')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Catégorie -->
        <div>
            <label>Catégorie</label>
            <div>
                @foreach($categories as $category)
                    <label>
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'checked' : '' }} required>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('category_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Marque -->
        <div>
            <label for="brand_id">Marque</label>
            <select name="brand_id" id="brand_id">
                <option value="">Sélectionnez une marque</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ajouter une nouvelle marque -->
        <div>
            <label for="new_brand">Nouvelle marque (si pas trouvée dans la liste)</label>
            <input type="text" name="new_brand" id="new_brand" value="{{ old('new_brand') }}">
            @error('new_brand')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div>
            <label for="image">Image</label>
            @if($product->image)
                <p>Image actuelle :</p>
                <img src="{{ asset('storage/' . $product->image) }}" alt="Image actuelle" style="max-width: 200px;">
            @endif
            <input type="file" name="image" id="image" accept="image/*">
            @error('image')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Variantes -->
        <h2>Variante(s)</h2>
        <div id="variants">
            @foreach($product->productVariants as $index => $variant)
            <div class="variant">
                <div>
                    <label for="variant_slug">Slug de la variante</label>
                    <input type="text" name="variants[{{ $index }}][slug]" id="variant_slug" value="{{ old('variants.' . $index . '.slug', $variant->slug) }}" required>
                    @error('variants.0.slug')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_volume">Volume</label>
                    <input type="text" name="variants[{{ $index }}][volume]" id="variant_volume" value="{{ old('variants.' . $index . '.volume', $variant->volume) }}" required>
                    @error('variants.0.volume')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_stock_quantity">Quantité en stock</label>
                    <input type="number" name="variants[{{ $index }}][stock_quantity]" id="variant_stock_quantity" value="{{ old('variants.' . $index . '.stock_quantity', $variant->stock_quantity) }}" required>
                    @error('variants.0.stock_quantity')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_price_without_tax">Prix HT (en centimes)</label>
                    <input type="number" name="variants[{{ $index }}][price_without_tax]" id="variant_price_without_tax" value="{{ old('variants.' . $index . '.price_without_tax', $variant->price_without_tax) }}" required>
                    @error('variants.0.price_without_tax')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_tax_amount">Montant de la taxe</label>
                    <input type="number" name="variants[{{ $index }}][tax_amount]" id="variant_tax_amount" value="{{ old('variants.' . $index . '.tax_amount', $variant->tax_amount) }}" required>
                    @error('variants.0.tax_amount')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="variant_available">Disponible</label>
                    <input type="checkbox" name="variants[{{ $index }}][available]" id="variant_available" value="{{ old('variants.' . $index . '.available', $variant->available) }}" required>
                    @error('variants.0.available')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endforeach
        </div>
        
        <button type="button" id="add_variant">Ajouter une variante</button>
        <button type="submit">Mettre à jour le produit</button>
    </form>

    <a href="{{ route('admin.index') }}">Retour</a>
</x-layout>