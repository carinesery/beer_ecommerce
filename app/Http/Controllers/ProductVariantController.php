<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Http\Requests\ProductVariantStoreRequest;
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{
    
    public function index()
    {
        // Les variantes apparaissent directement dans le Dashboard administrateur
    }

    
    public function create(Product $product)
    {
        return view('productvariants.create', compact('product'));
    }

    
    public function store(Product $product, ProductVariantStoreRequest $productvariantstorerequest)
    {
        
        // Autorisation
        

        // Enregistrement de la validation
        $data = $productvariantstorerequest->validated();

        // Ajout de la slugification
        $data['slug'] = Str::slug($data['slug']);
        $data['product_id'] = $product->id;

        // Enregistrement
        $product->productVariants()->create($data);

        // Redirection
        return redirect()->route('admin.index')->with('success', 'La variante du produit a été ajoutée avec succès.');

    }

    
    public function show(string $id)
    {
        // Les informations des variantes apparaissent directement dans le Dashboard administrateur
    }


    public function edit(ProductVariant $productvariant)
    {

        return view('productvariants.edit', compact('productvariant'));
    }

    
    public function update(ProductVariantStoreRequest $productvariantstorerequest, Productvariant $productvariant)
    {
        // Autorisation

        // Mise à jour
        $data = $productvariantstorerequest->validated();
        $data['slug'] = Str::slug($data['slug']); 
        $productvariant->update($data);

        // Redirection
        return redirect()->route('admin.index')->with('success', 'La variante du produit mise à jour avec succès.');

    }


    public function todestroy(ProductVariant $productvariant)
    {
        return view('productvariants.delete', compact('productvariant'));
    }

   
    public function destroy(ProductVariant $productvariant)
    {
        $productvariant->delete(); // Il s'agit d'un softDeletes (suppression visible, pas définitive)
        return redirect()->route('admin.index')->with('success', 'La variante a bien été supprimée.');
    }
}
