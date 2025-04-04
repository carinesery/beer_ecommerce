<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(ProductVariant $variants)
    {
    
        $query = ProductVariant::with('product');

         // Ajout d'une pagination. 20 livres par pages
         $variants = $query->paginate(20)->withQueryString();

        return view('admins.admin', [
                'variants' => $variants,
            ]);
    }

    // Afficher le formulaire de modification du produit
    // public function edit(Product $product)
    // {
    //     // Récupérer le produit à modifier
    //     $product = Product::findOrFail($product->id);

    //     // Récupérer les catégories et les marques disponibles
    //     $categories = Category::all();
    //     $brands = Brand::all();

    //     // Passer le produit, les catégories et les marques à la vue
    //     return view('products.edit', compact('product', 'categories', 'brands'));
    // }

}