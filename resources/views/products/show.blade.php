<x-layout>
    <div class="container mx-auto" style="display: flex; flex-direction:row; gap: 2rem">
        <span style="background-color: grey; width: fit-content; height: 400px; display: inline-block">
            {{ $product->image }}
        </span>
        <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit">
        <div>
            <h1 style="font-size: 2rem; font-weight:bold; text-transform: capitalize">
                {{ $product->name }}
            </h1>
            <span>{{ $product->category->name }}</span>
            <p>{{ $product->description }}</p>
        </div>
    </div>
</x-layout>