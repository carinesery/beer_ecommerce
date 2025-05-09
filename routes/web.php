<?php

use App\Http\Controllers\Admin\AdminOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;

// Homepage
Route::get('/',\App\Http\Controllers\HomeController::class)->name('homepage');

// CRUD des Products
Route::controller(ProductController::class)->group(function() {
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products', 'store')->name('products.store');
    Route::get('/products/{product:slug}', 'show')->name('products.show');
    Route::get('/products/edit/{product}', 'edit')->name('products.edit');
    Route::put('/products/{product}', 'update')->name('products.update');
    Route::get('/products/delete/{product:slug}', 'todelete')->name('products.todelete');
    Route::delete('products/delete/{product:slug}', 'delete')->name('products.delete');
});


// CRUD des ProductVariants
Route::controller(ProductVariantController::class)->group(function() {
    Route::get('products/{product}/productvariants/create', 'create')->name('productvariants.create');
    Route::post('products/{product}/productvariants','store')->name('productvariants.store');
    Route::get('/products/{productvariant}/edit', 'edit')->name('productvariants.edit');
    Route::patch('/products/{productvariant}', 'update')->name('productvariants.update');
    Route::get('/products/{productvariant}/delete', 'todestroy')->name('productvariants.todestroy');
    Route::delete('/products/{productvariant}/delete', 'destroy')->name('productvariants.destroy');
});


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/admin/product', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

// CRUD partiel des AdminOrders
Route::controller(AdminOrderController::class)->group(function() {
    Route::get('/admin-orders', 'index')->name('admin-orders.index');
    Route::patch('/admin-orders/{order}/cancel', 'cancel')->name('admin-orders.cancel');
});

Route::get('/users/registration', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('/users/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');

// CRUD des OrderItems
Route::controller(OrderItemsController::class)->group(function() {
    Route::get('/order-items/show', 'create')->name('orderItems.create');
    Route::post('/order-items', 'store')->name('orderItems.store');
    Route::patch('/order-items/{order_item}', 'update')->name('order-items.update');
    Route::delete('order-items/{order_item}', 'destroy')->name('order-items.destroy');
});

// CRUD partiel du Cart
Route::controller(CartController::class)->group(function() {
    Route::get('/cart/show', 'show')->name('cart');
    Route::get('/cart/checkout', 'checkout')->name('cart.checkout');
});

// CRUD des Orders
Route::controller(OrderController::class)->group(function() {
    Route::get('/orders', 'index')->name('orders.index');
    Route::post('/orders', 'store')->name('orders.store');
    Route::get('/orders/confirmation/{order}', 'confirmation')->name('orders.confirmation');
    Route::get('orders/{order}', 'show')->name('orders.show');
    Route::get('orders/{order}/resumepayment', 'resumePayment')->name('orders.resumePayment');
    // Route::patch('orders/{order}/cancel', 'cancel')->name('orders.cancel');
});


// Route intermédiaire en GET pour rediriger vers Stripe via un POST automatique
Route::get('/orders/redirect/{order}', function (\App\Models\Order $order) {
    return view('orders.redirect', compact('order'));
})->name('orders.redirect');

/** Routes pour le paiement Stripe */
Route::controller(StripeController::class)->group(function() {
    Route::post('/checkout', 'checkout')->name('stripe.checkout');
    Route::get('/checkout/success', 'success')->name('stripe.success');
    Route::get('/checkout/cancel', 'cancel')->name('stripe.cancel');
});


// CRUD du UserAccount
Route::controller(UserAccountController::class)->group(function() {
    Route::get('/auth/register', 'create')->name('register.create');
    Route::post('/auth/register', 'store')->name('register.store');
    Route::get('/auth/show', 'show')->name('account.show');
    Route::get('/auth/edit', 'edit')->name('account.edit');
    Route::patch('/auth', 'update')->name('account.update');
    Route::get('/auth/delete', 'todestroy')->name('account.todestroy');
    Route::delete('/auth/delete', 'destroy')->name('account.destroy');
});

// A faire : 
Route::controller(PasswordController::class)->group(function() {
    Route::get('password/edit', 'edit')->name('password.edit');
    Route::put('password/change', 'update')->name('password.update');

});



// 1. Route pour vérification de l'email 
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
