@extends('layouts.app')

@section('title', 'Registro de Cliente - ReparaYa')

@section('content')
    <h2>Registro de nuevo cliente particular</h2>
    <form action="{{ route('register') }}" method="POST" style="max-width: 450px;">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono de contacto</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
        </div>

        <div class="form-group">
            <label for="password">Contraseña (mínimo 6 caracteres)</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Repetir contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Crear cuenta</button>
    </form>
@endsection