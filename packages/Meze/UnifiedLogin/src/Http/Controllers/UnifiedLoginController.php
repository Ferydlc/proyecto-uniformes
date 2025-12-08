<?php

namespace Meze\UnifiedLogin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UnifiedLoginController extends Controller
{
    /**
     * Muestra la vista del formulario
     */
    public function showLoginForm()
    {
        return view('unifiedlogin::login');
    }

    /**
     * Procesa el login unificado
     */
    public function login(Request $request)
    {
        // Validar formulario
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        // ================================
        // 🔥 1. Intentar login como ADMIN
        // ================================
        if (auth()->guard('admin')->attempt($credentials)) {
            session()->flash('success', 'Bienvenido Administrador');
            return redirect()->intended(route('admin.dashboard'));
        }

        // ==================================
        // 🔥 2. Intentar login como CUSTOMER
        // ==================================
        if (auth()->guard('customer')->attempt($credentials)) {
            session()->flash('success', 'Bienvenido Cliente');
            return redirect()->intended(route('shop.home.index')); 
        }

        // ================================
        // ❌ Ningún guard coincidio
        // ================================
        return redirect()
            ->back()
            ->withErrors(['email' => 'Credenciales incorrectas'])
            ->withInput();
    }

    /**
     * Cerrar sesión sin importar el tipo
     */
    public function logout(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            auth()->guard('admin')->logout();
        }

        if (auth()->guard('customer')->check()) {
            auth()->guard('customer')->logout();
        }

        return redirect()->route('unifiedlogin.show');
    }
}
