<?php

namespace Meze\UnifiedLogin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UnifiedLoginController extends Controller
{
    /**
     * Muestra la vista del formulario
     */
    public function showLoginForm()
    {
        // Si ya está autenticado como admin, redirigir al dashboard admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        }

        // Si ya está autenticado como customer, redirigir a la tienda
        if (Auth::guard('customer')->check()) {
            return redirect()->route('shop.home.index');
        }

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

        $remember = $request->boolean('remember', false);

        // ================================
        // 1. Intentar login como ADMIN
        // ================================
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            session()->flash('success', 'Bienvenido Administrador');
            return redirect()->intended(route('admin.dashboard.index'));
        }

        // ==================================
        // 2. Intentar login como CUSTOMER
        // ==================================
        if (Auth::guard('customer')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            session()->flash('success', 'Bienvenido Cliente');
            return redirect()->intended(route('shop.home.index')); 
        }

        // ================================
        // Ningún guard coincidió
        // ================================
        return redirect()
            ->back()
            ->withErrors(['email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'])
            ->withInput($request->only('email'));
    }

    /**
     * Cerrar sesión sin importar el tipo
     */
    public function logout(Request $request)
    {
        // Cerrar sesión de admin si está autenticado
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        // Cerrar sesión de customer si está autenticado
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'Has cerrado sesión correctamente');

        return redirect()->route('shop.customer.login.index');
    }
}