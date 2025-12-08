<?php

use Illuminate\Support\Facades\Route;
use Meze\UnifiedLogin\Http\Controllers\UnifiedLoginController;

Route::middleware('web')->group(function () {

    // Sobrescribe la ruta GET del login del customer
    Route::get('/customer/login', [UnifiedLoginController::class, 'showLoginForm'])
        ->name('shop.customer.login.index');

    // Sobrescribe la ruta POST del login del customer
    Route::post('/customer/login', [UnifiedLoginController::class, 'login'])
        ->name('shop.customer.login.create');
});
