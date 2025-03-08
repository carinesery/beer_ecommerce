<?php

use Illuminate\Support\Facades\Route;

Route::get('/',\App\Http\Controllers\HomeController::class);

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');