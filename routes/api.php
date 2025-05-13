<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StripeController;


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


/** Test d'une route api :D */
Route::get('/test', function () {
    return response()->json([
        'message' => 'Coucou depuis Laravel 🎉',
        'status' => 'success',
    ]);
});

/** Route api du AuthController */
Route::post('login', [AuthController::class, 'login']);


/** Routes api du OrderController */
Route::middleware('auth:sanctum')->prefix('orders')->controller(OrderController::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{order}/redirect', 'redirectToStripe');
    Route::get('/{order}/confirmation', 'confirmation'); // ? Renvoie une vue ...
    Route::get('/{order}', 'show');
    Route::get('/{order}/resumepayment', 'resumePayment');
});

/** Routes api du OrderItemsController */
Route::middleware('auth:sanctum')->prefix('order-items')->controller(OrderItemsController::class)->group(function() {
    Route::get('/create', 'create'); // ? Renvoie une vue ...
    Route::post('/', 'store');
    Route::patch('/{order_item}', 'update');
    Route::delete('/{order_item}', 'destroy');
});

/** Routes api du CartController */
Route::middleware('auth:sanctum')->prefix('cart')->controller(CartController::class)->group(function() {
    Route::get('/show', 'show');
    Route::get('/checkout', 'checkout');    
});


/** Routes api pour le paiement Stripe */
Route::middleware('auth:sanctum')->prefix('stripe-payment')->controller(StripeController::class)->group(function() {
    Route::post('/checkout', 'checkout');
    Route::get('/success', 'success');
    Route::get('/cancel', 'cancel');
});


