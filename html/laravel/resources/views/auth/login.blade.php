@extends('layouts.app')

@section('title', 'Iniciar sesión - ReparaYa')

@section('content')
    <h2>Iniciar sesión en ReparaYa</h2>
    <form action="{{ route('login') }}" method="POST" style="max-width: 450px;">
        @csrf
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Entrar</button>
        <p style="margin-top: 15px;">¿Eres cliente particular y no tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </form>
@endsection