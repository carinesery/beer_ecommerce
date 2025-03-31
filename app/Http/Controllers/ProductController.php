<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index() 
    {
    }

    public function create() 
    {
    }

    public function store(Request $request) 
    {
    }

    public function show(Product $product) // Récupère l'objet Product pour l'afficher
    {
        // dd($product); // Pour test, à enlever

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
