<x-layout title="Modifier un produit">
    <a href="{{ url()->previous() }}" class="inline-block mb-4 text-blue-600 hover:bg-blue-100 border border-blue-600 p-2 m-2 rounded">Retour</a>
    <a href="{{ route('products.show', $product) }}" class="inline-block mb-4 text-blue-600 hover:bg-blue-100 border border-blue-600 p-2 m-2 rounded">Voir le produit</a>

    <h1 class="text-4xl text-center my-10 font-bold mb-4">Modifier le produit {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product) }}" enctype="multipart/form-data" method="post"
    class="mx-auto my-10 border rounded-lg shadow-lg p-6 bg-white flex flex-col gap-4 w-200">
        @csrf
        @method('PUT') <!-- Indique que c'est une requête PUT pour la mise à jour -->
        @if ($errors->any())
            <div class="alert alert-danger text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="text-2xl font-bold mb-4">Produit</h2>

        <!-- Slug -->
        <div class=" flex flex-col gap-4">
            <label for="slug" class="font-semibold">Slug :</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required 
            class="border-2 border-gray-300 rounded w-100 p-2">
            @error('slug')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Nom du produit -->
        <div class="flex flex-col gap-4">
            <label for="name" class="font-semibold">Nom du produit :</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
            class="border-2 border-gray-300 rounded w-100 p-2">
            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Description -->
        <div class="flex flex-col gap-4">
            <label for="description" class="font-semibold">Description :</label>
            <textarea name="description" id="description" required
            class="border-2 border-gray-300 rounded w-100 p-2 h-32">
            {{ old('description', $product->description) }}
        </textarea>
            @error('description')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Degré d'alcool -->
        <div class="flex flex-col gap-4">
            <label for="alcohol_degree" class="font-semibold">Degré d'alcool :</label>
            <input type="number" name="alcohol_degree" id="alcohol_degree" value="{{ old('alcohol_degree', $product->alcohol_degree) }}" required 
            class="border-2 border-gray-300 rounded w-100 p-2">
            @error('alcohol_degree')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Catégorie -->
        <div class="flex flex-col gap-2 border-2 border-gray-300 pb-4 rounded w-100 p-4">
                <label class="font-semibold">Catégorie :</label>
                @foreach($categories as $category)
                    <label>
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'checked' : '' }} required>
                        {{ $category->name }}
                    </label>
                @endforeach
            @error('category_id')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Marque -->
        <div class="flex flex-col gap-4">
            <label for="brand_id" class="font-semibold">Marque :</label>
            <select name="brand_id" id="brand_id" class="border-2 border-gray-300 rounded w-100 p-2">
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
        <div class="flex flex-col gap-4">
            <label for="new_brand" class="font-semibold">Nouvelle marque (si pas trouvée dans la liste) :</label>
            <input type="text" name="new_brand" id="new_brand" value="{{ old('new_brand') }}" 
            class="border-2 border-gray-300 rounded w-100 p-2">
            @error('new_brand')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div class="flex flex-col gap-4">
            <label for="image" class="font-semibold">Image :</label>
            @if($product->image)
            <div class="flex flex-col gap-4 border-2 border-gray-300 pb-4 rounded w-100 p-4">
                <p class="font-semibold">Image actuelle</p>
                <img src="{{ asset('storage/' . $product->image) }}" alt="Image actuelle" style="max-width: 200px;"
                class="border-2 border-gray-300 p-2 rounded w-30 h-32">
                <p class="text-sm text-gray-500">Si vous téléchargez une nouvelle image, l'ancienne sera remplacée.</p>
            </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*" 
            class="border-2 border-gray-300 rounded w-100 p-2 ">
            @error('image')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white rounded p-2">Mettre à jour le produit</button>
    </form>

    <a href="{{ route('admin.index') }}">Retour</a>
</x-layout>