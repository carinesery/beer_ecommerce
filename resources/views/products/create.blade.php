<x-layout title="Ajouter un produit">
    <a href="{{ url()->previous() }}" class="inline-block mb-4 text-blue-600 hover:bg-blue-100 border border-blue-600 p-2 m-2 rounded">Retour</a>
    <form action="{{ route('products.store') }}" enctype="multipart/form-data" method="post" class="mx-auto my-10 border rounded-lg shadow-lg p-6 bg-white flex flex-col gap-4 w-200">
        <!-- En-tête de la page -->
        <h1 class="text-4xl text-center my-10 font-bold mb-4">Ajouter un produit</h1>
        
        <!-- Formulaire pour ajouter un produit -->
    @csrf <!-- Token pour vérifier que la requête est légitime et provient de l'application -->
        <h2 class="text-2xl font-bold mb-4">Produit</h2>
        <div class="flex flex-col gap-4">
            <label for="name" class="font-semibold">Nom du produit :</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="border-2 border-gray-300 rounded w-100">
            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col gap-4">
            <label for="slug" class="font-semibold">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required class="border-2 border-gray-300 rounded w-100">
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col gap-4">
            <label for="description" class="font-semibold">Description :</label>
            <textarea name="description" id="description" required class="border-2 border-gray-300 rounded w-100">{{ old('description') }}</textarea>
            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <label for="alcohol_degree" class="font-semibold">Degré d'alcool :</label>
            <input type="number" name="alcohol_degree" id="alcohol_degree" value="{{ old('alcohol_degree') }}" required class="border-2 border-gray-300 rounded w-100">
            @error('alcohol_degree')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col gap-4 border-2 border-gray-300 pb-4 rounded w-100 p-4">
            <div class="font-semibold ">Catégorie :</div>
            <div class="flex flex-col gap-2 ml-4">
                @foreach($categories as $category)
                    <div>
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                            {{ old('category_id') == $category->id ? 'checked' : '' }} required>
                            <label for="category_id_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('category_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sélectionner une marque existante -->
        <div class="flex flex-col gap-4">
            <label for="brand_id" class="font-semibold">Marque :</label>
            <select name="brand_id" id="brand_id" class="border-2 border-gray-300 rounded w-100">
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
        <div class="flex flex-col gap-4">
            <label for="new_brand" class="font-semibold">Nouvelle marque (si pas trouvée dans la liste) :</label>
            <input type="text" name="new_brand" id="new_brand" value="{{ old('new_brand') }}" class="border-2 border-gray-300 rounded w-100">
            @error('new_brand')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

         <!-- Champ pour la description de la nouvelle marque -->
         <div class="flex flex-col gap-4">
            <label for="new_brand_description" class="font-semibold">Description de la nouvelle marque :</label>
            <textarea name="new_brand_description" id="new_brand_description" class="border-2 border-gray-300 rounded w-100">{{ old('new_brand_description') }}</textarea>
            @error('new_brand_description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Champ pour télécharger le logo de la nouvelle marque -->
        <div class="flex flex-col gap-4">
            <label for="new_brand_logo" class="font-semibold">Logo de la nouvelle marque :</label>
            <input type="file" name="new_brand_logo" id="new_brand_logo" accept="image/*" class="border-2 border-gray-300 rounded w-100">
            @error('new_brand_logo')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <label for="image" class="font-semibold">Image :</label>
            <input type="text" name="image" id="image" required class="border-2 border-gray-300 rounded w-100">
            @error('image')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <hr class="my-4 border-gray-300">
        <!-- Partie Variantes -->
        <h2 class="text-2xl font-bold mb-4">Variante(s)</h2>

        <div id="variants" class="flex flex-col gap-4">
            <div class="flex flex-col gap-4 variant p-4">
                <div class="font-semibold">Variante 1</div>
                <div class="flex flex-col gap-4">
                    <label for="variant_slug" class="font-semibold">Slug de la variante :</label>
                    <input type="text" name="variants[0][slug]" id="variant_slug" value="{{ old('variants.0.slug') }}" required class="border-2 border-gray-300 rounded w-100">
                    @error('variants.0.slug')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <label for="variant_volume" class="font-semibold">Volume :</label>
                    <input type="text" name="variants[0][volume]" id="variant_volume" value="{{ old('variants.0.volume') }}" required class="border-2 border-gray-300 rounded w-100">
                    @error('variants.0.volume')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <label for="variant_stock_quantity" class="font-semibold">Quantité en stock :</label>
                    <input type="number" name="variants[0][stock_quantity]" id="variant_stock_quantity" value="{{ old('variants.0.stock_quantity') }}" required class="border-2 border-gray-300 rounded w-100">
                    @error('variants.0.stock_quantity')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <label for="variant_price_without_tax" class="font-semibold">Prix HT (en centimes) :</label>
                    <input type="number" name="variants[0][price_without_tax]" id="variant_price_without_tax" value="{{ old('variants.0.price_without_tax') }}" required class="border-2 border-gray-300 rounded w-100">
                    @error('variants.0.price_without_tax')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <label for="variant_tax_amount" class="font-semibold">Montant de la taxe :</label>
                    <input type="number" name="variants[0][tax_amount]" id="variant_tax_amount" value="{{ old('variants.0.tax_amount') }}" required class="border-2 border-gray-300 rounded w-100">
                    @error('variants.0.tax_amount')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 mt-4">
                    <input type="checkbox" name="variants[0][available]" id="variant_available" value="1" {{ old('variants.0.available') ? 'checked' : '' }} class="border-2 border-gray-300 rounded w-10">
                    <label for="variant_available" class="font-semibold">Si disponible</label>
                    @error('variants.0.available')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex gap-4 mt-4">
            <button type="button" id="add_variant" class="border-2 border-gray-300 rounded px-4 py-2 bg-gray-200">Ajouter une variante</button>
            <button type="submit" class="border-2 border-gray-300 rounded px-4 py-2 bg-gray-200">Créer le produit</button>
        </div>
    </form>
    <a href="{{ route('admin.index') }}">Retour</a>
</x-layout>