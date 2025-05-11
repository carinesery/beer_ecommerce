<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderItemsController;

 /** POur récupérer ke token d'identification */

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// http://127.0.0.1:8000/api/users

Route::get('/products', [ProductController::class, 'index']);
// http://127.0.0.1:8000/api/products
Route::get('/products/{id}', [ProductController::class, 'show']);
// // http://127.0.0.1:8000/api/products/{id}

// Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products
// Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products/{id}
// Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products/{id}


/** Test d'une api */
Route::get('/test', function () {
    return response()->json([
        'message' => 'Coucou depuis Laravel 🎉',
        'status' => 'success',
    ]);
});

Route::post('login', [AuthController::class, 'login']);

/** Routes du OrderItemsController */
Route::middleware('auth:sanctum')->prefix('order-items')->controller(OrderItemsController::class)->group(function() {
    Route::get('/create', 'create');
    Route::post('/', 'store');
    Route::patch('/{order_item}', 'update');
    Route::delete('/{order_item}', 'destroy');
});


/** Routes du CartController */
Route::middleware('auth:sanctum')->prefix('cart')->controller(CartController::class)->group(function() {
    Route::get('/show', 'show');
    Route::get('/checkout', 'checkout');    
});

