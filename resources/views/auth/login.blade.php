<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Brunett POS</title>
    <link rel="stylesheet" href="{{ asset('css/design_system.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
        }
        .logo-text span { color: var(--brand-accent); }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; color: rgba(255,255,255,0.7); margin-bottom: 0.5rem; font-size: 0.9rem; }
        .form-input {
            width: 100%;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--brand-accent);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        }
        .btn-login {
            width: 100%;
            padding: 1.1rem;
            background: var(--brand-accent);
            color: #1e293b;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1rem;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.4); }
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-area">
        <div class="logo-text">BRUNETT<span>POS</span></div>
        <p style="color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-top: 0.5rem;">Gestión Administrativa y Contable</p>
    </div>

    @if($errors->any())
        <div class="error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-input" placeholder="admin@brunett.com" required autofocus>
        </div>
        
        <div class="form-group">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; color: rgba(255,255,255,0.6); font-size: 0.85rem; cursor: pointer;">
                <input type="checkbox" name="remember" style="accent-color: var(--brand-accent);"> Recordarme
            </label>
            <a href="#" style="color: var(--brand-accent); font-size: 0.85rem; text-decoration: none;">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-login">Acceder al Sistema</button>
    </form>
    
    <div style="text-align: center; margin-top: 2rem; color: rgba(255,255,255,0.4); font-size: 0.8rem;">
        &copy; {{ date('Y') }} ATGU SAS - Brunett Ecuador
    </div>
</div>

<script>lucide.createIcons();</script>
</body>
</html>
