<x-layout title="E-commerce de bières">
    <h1 class="py-3">Bienvenue @auth <b>{{ auth()->user()->firstname }}</b> 
    @endauth</h1>
    <div class="max-w-sm rounded overflow-hidden shadow-lg p-4 border-4 border-blue-400">
        <h2 class="p-8 text-center font-bold">Liste des Utilisateurs</h2>
        @foreach ($users as $user)
                <span>{{ $user->firstname }}</span> <br>
        @endforeach
    </div>
    <h1 class="p-8 text-4xl text-center font-bold">Toutes nos bières</h1>
        <div>
            <a href="{{ route('homepage') }}">Toutes les catégories</a>
            @foreach($categories as $category)
            <a href="{{ route('homepage', ['category' => $category->id]) }}">{{ $category->name }}</a>
            @endforeach
        </div>
        
        @foreach ($products as $product)
            <div class="grid text-center grid-cols-4 gap-4">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit"><br>    
                    <h2>{{ $product->name }}</h2> 
                    <span>{{ $product->slug }}</span><br> <!-- Uniquement pour test -->
                    <span>
                        {{ $product->brand ? $product->brand->name : 'Aucune marque' }}
                    </span><br>
                    <span class="inline-block bg-amber-100 rounded-xl px-3 py-1 text-sm">
                        {{ $product->category ? $product->category->name : 'Aucune catégorie'}}
                    </span><br>
                    <!-- @foreach ($product->productVariants as $variant)
                        <span>A partir de {{ $variant->price_without_tax/100 }} €</span><br>
                    @endforeach -->
                    <span>
                        A partir de {{ $variant->price_without_tax/100 }} €
                    </span><br>
                    <a href="{{ route('products.show', ['product' => $product->slug]) }}" class="inline-block bg-blue-100 rounded-xl px-3 py-1 text-sm">
                        Voir le produit
                    </a>
                </div>
            </div>        
        @endforeach
        {{ $products->links() }}
</x-layout>