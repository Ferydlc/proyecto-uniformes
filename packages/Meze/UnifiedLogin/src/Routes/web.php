<?php

use Illuminate\Support\Facades\Route;
use Meze\UnifiedLogin\Http\Controllers\UnifiedLoginController;

Route::group(['middleware' => ['web']], function () {

    Route::get('/unified-login', [UnifiedLoginController::class, 'showLoginForm'])
        ->name('unifiedlogin.show');

    Route::post('/unified-login', [UnifiedLoginController::class, 'login'])
        ->name('unifiedlogin.login');

    Route::post('/unified-logout', [UnifiedLoginController::class, 'logout'])
        ->name('unifiedlogin.logout');
});
