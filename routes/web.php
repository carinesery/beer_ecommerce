<?php

use Illuminate\Support\Facades\Route;

Route::get('/',\App\Http\Controllers\HomeController::class)->name('homepage');
Route::get('/products/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');