@extends('shop::layouts.master')

@section('page_title')
    Inicio de sesión unificado
@endsection

@section('content')
    <div class="container" style="max-width: 450px; margin: 60px auto;">
        
        <h2 style="text-align: center; margin-bottom: 25px;">
            Iniciar sesión
        </h2>

        {{-- Mostrar mensajes flash --}}
        @if(session('success'))
            <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding: 10px; background: #f8d7da; color: #721c24; border-radius: 6px; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('unifiedlogin.login') }}" style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0px 0px 12px rgba(0,0,0,0.1);">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom: 15px;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 15px;">
                <label>Contraseña</label>
                <input type="password" name="password"
                    style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
            </div>

            <button type="submit"
                style="width:100%; padding:12px; background:#007bff; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                Entrar
            </button>
        </form>
    </div>
@endsection
