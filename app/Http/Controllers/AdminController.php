<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function show(ProductVariant $variants)
    // {
    
    //     $query = ProductVariant::with('product');

    //      // Ajout d'une pagination. 20 livres par pages
    //      $variants = $query->paginate(20)->withQueryString();

    //     return view('admins.admin', [
    //             'variants' => $variants,
    //         ]);
    // }

    public function index()
    {
    
        $query = Product::with('productVariants');

         // Ajout d'une pagination. 20 livres par pages
         $products = $query->paginate(25)->withQueryString(); // Conserve les filtres lors changement de page

        return view('admin.product.index', [
                'products' => $products,
            ]);
    }

    public function edit(Product $product) 
    {
        // Cette méthode permet afficher la vue pour modifier un produit. 
        // $categories = Category::all(); // Récupère les catégories
        // $brands = Brand::all(); // Récupère les catégories

        // return view('products.edit', compact('product', 'categories', 'brands'));
        return view('products.edit', ['product' => $product]);


    }

}