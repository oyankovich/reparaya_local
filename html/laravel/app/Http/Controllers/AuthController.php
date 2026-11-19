<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol(Auth::user()->rol);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return $this->redirigirSegunRol(Auth::user()->rol);
        }

        return back()->withErrors([
            'email' => 'El correo electrónico o la contraseña no son correctos.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol(Auth::user()->rol);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'password' => Hash::make($datos['password']),
            'rol' => 'particular',
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('cliente.dashboard')
            ->with('success', 'Registro completado correctamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }

    private function redirigirSegunRol(string $rol)
    {
        return match ($rol) {
            'admin' => redirect()->route('admin.dashboard'),
            'tecnico' => redirect()->route('tecnico.dashboard'),
            'gestora' => redirect()->route('gestora.dashboard'),
            default => redirect()->route('cliente.dashboard'),
        };
    }
}