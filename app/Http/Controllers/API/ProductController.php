<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('productVariants');
        // $products = Product::with('productVariants')->paginate(25); // Charge les variants avec les produits
        $productsvariants = ProductVariant::min('price_without_tax'); // Récupère la variation la plus basse des produits
        $categories = Category::all(); // Récupère les catégories
        $brands = Brand::all(); // Récupère les catégories

        // Ajout d'une condition pour filtrer les livres selon leur catégorie
        if($request->has('category')) {
            $query->where('category_id', $request->query('category'));
        }

        if ($request->has('brand')) {
            $query->where('brand_id', $request->query('brand'));
        }

        $page = $request->get('page', 1);

        $products = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return response()->json([
            'products' => $products, 
            'productsvariants' => $productsvariants, 
            'categories' => $categories, 
            'brands' => $brands
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('productVariants')->findOrFail($id); // Charge les variants avec le produit

    // Filtrer les catégories associées au produit
    $categories = Category::whereHas('products', function ($query) use ($id) {
        $query->where('id', $id);
    })->get();

    // Filtrer les marques associées au produit
    $brands = Brand::whereHas('products', function ($query) use ($id) {
        $query->where('id', $id);
    })->get();

    // Filtrer les variantes associées au produit
    $productVariants = ProductVariant::where('product_id', $id)->get();

    return response()->json([
        'product' => $product,
        'categories' => $categories,
        'brands' => $brands,
        'productVariants' => $productVariants
    ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
