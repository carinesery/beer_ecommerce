<x-layout>
    <form class="flex gap-4 py-4 container mx-auto">
        <div> 
            <img src="{{ asset('storage/app/public/images/' . $product->image) }}" alt="Image du produit" class="w-100 h-100 border">
        </div>
        <div>
            <h1 style="font-size: 2rem; font-weight:bold; text-transform: capitalize">
                {{ $product->name }} {{ $productVariant->slug}} Cl
            </h1>
           
            <h2>{{ $product->alcohol_degree }} %</h2>
            <span>{{ $product->category->name }}</span>
            <p>{{ $product->description }}</p>
        </div>
    </form>
</x-layout>