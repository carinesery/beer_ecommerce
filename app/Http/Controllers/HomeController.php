<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $users = User::all(); // Récupère les utilisateurs
        $query = Product::with('productVariants');
        // $products = Product::with('productVariants')->paginate(25); // Charge les variants avec les produits
        $productsvariants = ProductVariant::min('price_without_tax'); // Récupère la variation la plus basse des produits
        $categories = Category::all(); // Récupère les catégories
        $brands = Brand::all(); // Récupère les catégories

        if($request->has('category')) {
            $query->where('category_id', $request->query('category'));
        }

        if ($request->has('brand')) {
            $query->where('brand_id', $request->query('brand'));
        }

        $products = $query->paginate(25)->withQueryString();

        return view('index', [
            'users' => $users,
            'products' => $products,
            'productsvariants' => $productsvariants,
            'categories' =>$categories,
            'brands' =>$brands,
        ]);
    }

    
}
