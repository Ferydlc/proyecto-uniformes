<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Colegio Meze</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 48px 40px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container img {
            max-width: 180px;
            height: auto;
            margin-bottom: 16px;
        }
        
        .logo-container h1 {
            color: #1e3c72;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        
        .logo-container p {
            color: #64748b;
            font-size: 14px;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        label {
            display: block;
            color: #334155;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
            background: #f8fafc;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2a5298;
            background: white;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }
        
        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 400;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2a5298;
        }
        
        .remember-me label {
            margin-bottom: 0;
            font-weight: 400;
            font-size: 14px;
            color: #64748b;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.3px;
            margin-bottom: 14px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 60, 114, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }

        .btn-secondary {
            width: 100%;
            padding: 15px;
            background: white;
            color: #2a5298;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #2a5298;
        }

        .btn-secondary:active {
            transform: scale(0.98);
        }
        
        .info-text {
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
            line-height: 1.6;
        }
        
        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 400;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 12px;
            position: relative;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo-container">
                {{-- Reemplaza la ruta con la ubicación real de tu logo --}}
                <img src="{{ asset('images/logo-meze.png') }}" alt="Colegio Meze" onerror="this.style.display='none'">
                
                <h1>Colegio Meze</h1>
                <p>Portal de acceso</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('shop.customer.session.create') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="usuario@colegiomeze.edu.mx"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Ingresa tu contraseña"
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Mantener sesión iniciada</label>
                </div>

                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>
            </form>

            <div class="divider">
                <span>o</span>
            </div>

            <a href="{{ route('shop.home.index') }}" class="btn-secondary">
                ← Regresar
            </a>

            <div class="info-text">
            Copyright © 2025 Todos los derechos reservados | para Colegio Meze     
            </div>
        </div>
    </div>
</body>
</html>