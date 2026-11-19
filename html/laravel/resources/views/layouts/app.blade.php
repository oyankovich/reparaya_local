<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ReparaYa - Gestión de Incidencias')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; color: #333; }
        header { background-color: #1e293b; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; margin-right: 15px; font-weight: bold; }
        header a:hover { text-decoration: underline; }
        .nav-right { display: flex; align-items: center; gap: 15px; }
        .badge-rol { background-color: #3b82f6; padding: 4px 10px; border-radius: 4px; font-size: 12px; text-transform: uppercase; }
        .btn-logout { background-color: #ef4444; color: #fff; border: none; padding: 7px 12px; border-radius: 4px; cursor: pointer; }
        .container { max-width: 1100px; margin: 30px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .alert-success { background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #86efac; }
        .alert-error { background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #fca5a5; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 9px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; }
        .btn { display: inline-block; background-color: #2563eb; color: #fff; padding: 10px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn:hover { background-color: #1d4ed8; }
        .btn-danger { background-color: #dc2626; }
        .btn-secondary { background-color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border: 1px solid #e2e8f0; text-align: left; }
        th { background-color: #f1f5f9; }
    </style>
</head>
<body>
    <header>
        <div>
            <a href="{{ url('/') }}">ReparaYa</a>
            @auth
                @if(Auth::user()->rol === 'particular')
                    <a href="{{ route('cliente.dashboard') }}">Mis Incidencias</a>
                @elseif(Auth::user()->rol === 'tecnico')
                    <a href="{{ route('tecnico.dashboard') }}">Panel Técnico</a>
                @elseif(Auth::user()->rol === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                @elseif(Auth::user()->rol === 'gestora')
                    <a href="{{ route('gestora.dashboard') }}">Panel Gestora B2B</a>
                @endif
            @endauth
        </div>

        <div class="nav-right">
            @auth
                <span>{{ Auth::user()->nombre }}</span>
                <span class="badge-rol">{{ Auth::user()->rol }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}">Registrarse</a>
            @endauth
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>