<?php

use Illuminate\Support\Facades\Route;
use Meze\UnifiedLogin\Http\Controllers\UnifiedLoginController;

// Estas rutas sobrescriben las rutas originales de Bagisto
// usando los MISMOS nombres de ruta

Route::middleware('web')->group(function () {

    // ========================================
    // CUSTOMER LOGIN - Sobrescribe rutas de Shop
    // ========================================
    
    // GET /customer/login - Mostrar formulario
    Route::get('/customer/login', [UnifiedLoginController::class, 'showLoginForm'])
        ->name('shop.customer.session.index');

    // POST /customer/login - Procesar login
    Route::post('/customer/login', [UnifiedLoginController::class, 'login'])
        ->name('shop.customer.session.create');

    // ========================================
    // ADMIN LOGIN - Sobrescribe rutas de Admin
    // ========================================
    
    // GET /admin/login - Mostrar formulario
    Route::get('/admin/login', [UnifiedLoginController::class, 'showLoginForm'])
        ->name('admin.session.create');

    // POST /admin/login - Procesar login
    Route::post('/admin/login', [UnifiedLoginController::class, 'login'])
        ->name('admin.session.store');

    // ========================================
    // LOGOUT - Nuevas rutas unificadas
    // ========================================
    
    // DELETE /customer/session - Logout customer (sobrescribe original)
    Route::delete('/customer/session', [UnifiedLoginController::class, 'logout'])
        ->name('shop.customer.session.destroy');
        
    // DELETE /admin/session - Logout admin (sobrescribe original)
    Route::delete('/admin/session', [UnifiedLoginController::class, 'logout'])
        ->name('admin.session.destroy');
});