<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// http://127.0.0.1:8000/api/users

Route::post('/authenticate', [LoginController::class, 'authenticate']);
// http://127.0.0.1:8000/api/login

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