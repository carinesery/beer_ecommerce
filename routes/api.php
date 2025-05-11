<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; /** POur récupérer ke token d'identification */

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

/** Routes du CartController */
Route::middleware('auth:sanctum')->get('cart/show', [CartController::class, 'show']);
Route::middleware('auth:sanctum')->get('cart/checkout', [CartController::class, 'checkout']);
