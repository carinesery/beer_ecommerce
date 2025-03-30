<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(ProductVariant $variants)
    {
       
        // $products = Product::all();
        // return view('admins.admin', [
        //     'products' => $products,
        // ]);
        $variants = ProductVariant::with('product')->get();

        return view('admins.admin', [
                'variants' => $variants,
            ]);
    }
}
