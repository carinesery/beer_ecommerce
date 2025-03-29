<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(Product $products)
    {
       
        $products = Product::all();
        return view('admins.admin', [
            'products' => $products,
        ]);

    }
}
