<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/users

Route::post('/register', [UserController::class, 'store']);
// http://127.0.0.1:8000/api/register

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return response()->json(['message' => 'Email vérifié !']);
// })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');



Route::post('/authenticate', [LoginController::class, 'authenticate']);
// http://127.0.0.1:8000/api/authenticate
Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);
// http://127.0.0.1:8000/api/logout

Route::get('/products', [ProductController::class, 'index']);
// http://127.0.0.1:8000/api/products
Route::get('/products/{id}', [ProductController::class, 'show']);
// // http://127.0.0.1:8000/api/products/{id}

// Exemple de route :
// Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products
// Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products/{id}
// Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');
// // http://127.0.0.1:8000/api/products/{id}