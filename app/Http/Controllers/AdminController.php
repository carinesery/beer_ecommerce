<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
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
}