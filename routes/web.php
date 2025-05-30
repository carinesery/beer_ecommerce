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
use App\Http\Controllers\DataController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;


// Homepage
Route::get('/',\App\Http\Controllers\HomeController::class)->name('homepage');

// CRUD des Products
Route::controller(ProductController::class)->group(function() {
    Route::get('/products/create', 'create')->name('products.create')->middleware([Role::class.':admin']);;
    Route::post('/products', 'store')->name('products.store')->middleware([Role::class.':admin']);;
    Route::get('/products/{product:slug}', 'show')->name('products.show')->middleware([Role::class.':admin']);;
    Route::get('/products/edit/{product}', 'edit')->name('products.edit')->middleware([Role::class.':admin']);;
    Route::put('/products/{product}', 'update')->name('products.update')->middleware([Role::class.':admin']);;
    Route::get('/products/delete/{product:slug}', 'todelete')->name('products.todelete')->middleware([Role::class.':admin']);;
    Route::delete('products/delete/{product:slug}', 'delete')->name('products.delete')->middleware([Role::class.':admin']);;
});


// CRUD des ProductVariants
Route::controller(ProductVariantController::class)->group(function() {
    Route::get('products/{product}/productvariants/create', 'create')->name('productvariants.create')->middleware([Role::class.':admin']);
    Route::post('products/{product}/productvariants','store')->name('productvariants.store')->middleware([Role::class.':admin']);
    Route::get('/products/{productvariant}/edit', 'edit')->name('productvariants.edit')->middleware([Role::class.':admin']);
    Route::patch('/products/{productvariant}', 'update')->name('productvariants.update')->middleware([Role::class.':admin']);
    Route::get('/products/{productvariant}/delete', 'todestroy')->name('productvariants.todestroy')->middleware([Role::class.':admin']);
    Route::delete('/products/{productvariant}/delete', 'destroy')->name('productvariants.destroy')->middleware([Role::class.':admin']);
});


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');


// CRUD partiel des AdminOrders
Route::get('/admin/product', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware([Role::class.':admin']);
Route::controller(AdminOrderController::class)->group(function() {
    Route::get('/admin-orders', 'index')->name('admin-orders.index')->middleware([Role::class.':admin']);
    Route::patch('/admin-orders/{order}/cancel', 'cancel')->name('admin-orders.cancel')->middleware([Role::class.':admin']);
});

Route::get('/users/registration', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create')->middleware([Role::class.':admin']);
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store')->middleware([Role::class.':admin']);
Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users')->middleware([Role::class.':admin']);
Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy')->middleware([Role::class.':admin']);
Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show')->middleware([Role::class.':admin']);
Route::get('/users/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit')->middleware([Role::class.':admin']);
Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware([Role::class.':admin']);

// CRUD des OrderItems
Route::middleware('auth')->controller(OrderItemsController::class)->group(function() {
    Route::get('/order-items/create', 'create')->name('order-items.create')->middleware([Role::class.':admin']);
    Route::post('/order-items', 'store')->name('order-items.store')->middleware([Role::class.':admin']);
    Route::patch('/order-items/{order_item}', 'update')->name('order-items.update')->middleware([Role::class.':admin']);
    Route::delete('order-items/{order_item}', 'destroy')->name('order-items.destroy')->middleware([Role::class.':admin']);
});

// CRUD partiel du Cart
Route::middleware('auth')->controller(CartController::class)->group(function() {
    Route::get('/cart/show', 'show')->name('cart');
    Route::get('/cart/checkout', 'checkout')->name('cart.checkout');
});

// CRUD des Orders
Route::middleware('auth')->controller(OrderController::class)->group(function() {
    Route::get('/orders', 'index')->name('orders.index');
    Route::post('/orders', 'store')->name('orders.store');
    Route::get('/orders/{order}/redirect', 'redirectToStripe')->name('orders.redirect');
    Route::get('/orders/{order}/confirmation', 'confirmation')->name('orders.confirmation');
    Route::get('orders/{order}', 'show')->name('orders.show');
    Route::get('orders/{order}/resumepayment', 'resumePayment')->name('orders.resumePayment');
});

/** Routes pour le paiement Stripe */
Route::middleware('auth')->controller(StripeController::class)->group(function() {
    Route::post('/stripe-payment/checkout', 'checkout')->name('stripe.checkout');
    Route::get('/stripe-payment/success', 'success')->name('stripe.success');
    Route::get('/stripe-payment/cancel', 'cancel')->name('stripe.cancel');
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

// A faire : 
Route::controller(PasswordController::class)->group(function() {
    Route::get('password/edit', 'edit')->name('password.edit');
    Route::put('password/change', 'update')->name('password.update');

});


// Route pour vérification de l'email 
Route::get('/email/verify', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 2. Gère la validation du lien dans l'email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marque l'utilisateur comme "email_verified_at" rempli.

    return redirect('http://localhost:5173/connexion')->with('message', 'Votre adresse email a été vérifiée avec succès !');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 3. Renvoie un nouveau lien de vérification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Un nouveau lien de vérification a été envoyé sur votre adresse email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route pour le téléchargement de la base de données
Route::get('/database', [DataController::class, 'index'])->name('admin.data.index')->middleware([Role::class.':admin']);
Route::get('/database/download', [DataController::class, 'downloadDataBase'])->name('admin.data.downloadDB')->middleware([Role::class.':admin']);

// Route les statistiques
Route::get('/database', [StockController::class, 'index'])->name('admin.data.index')->middleware([Role::class.':admin']);