<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;

Route::get('/',\App\Http\Controllers\HomeController::class)->name('homepage');

Route::get('/products/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/products/edit/{product}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/admin/product', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

Route::get('/users/registration', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('/users/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');

Route::get('/products/show', [\App\Http\Controllers\OrderItemsController::class, 'create'])->name('orderItems.create');
Route::post('/products', [\App\Http\Controllers\OrderItemsController::class, 'store'])->name('orderItems.store');

// Route::get('/products/show', [\App\Http\Controllers\OrderController::class, 'create'])->name('order.create');
// Route::post('/products', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/confirmation/{order}', [OrderController::class, 'confirmation'])->name('orders.confirmation');

/** Routes pour le paiement Stripe */
Route::post('/checkout', [\App\Http\Controllers\StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/checkout/success', [\App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
Route::get('/checkout/cancel', [\App\Http\Controllers\StripeController::class, 'cancel'])->name('stripe.cancel');

// Route intermédiaire en GET pour rediriger vers Stripe via un POST automatique
Route::get('/orders/redirect/{order}', function (\App\Models\Order $order) {
    return view('orders.redirect', compact('order'));
})->name('orders.redirect');

Route::get('/auth/register', [userAccountController::class, 'create'])->name('register.create');
Route::post('/auth/register', [UserAccountController::class, 'store'])->name('register.store');
Route::get('auth/show', [UserAccountController::class, 'show'])->name('account.show');
Route::get('auth/delete', [UserAccountController::class, 'todestroy'])->middleware('auth')->name('register.todestroy');
Route::delete('auth/delete', [UserAccountController::class, 'destroy'])->middleware('auth')->name('register.destroy');

// Route pour vérification de l'email 
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 2. Gère la validation du lien dans l'email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marque l'utilisateur comme "email_verified_at" rempli.

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 3. Renvoie un nouveau lien de vérification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Un nouveau lien de vérification a été envoyé sur votre adresse email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
