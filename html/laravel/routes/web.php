<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteIncidenciaController;
use App\Http\Controllers\TecnicoIncidenciaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('login') : view('auth.login');
});

// Rutas públicas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rutas Cliente Particular
Route::middleware(['auth', 'role:particular'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', [ClienteIncidenciaController::class, 'index'])->name('dashboard');
    Route::get('/incidencias/crear', [ClienteIncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/incidencias', [ClienteIncidenciaController::class, 'store'])->name('incidencias.store');
    Route::get('/incidencias/{incidencia}', [ClienteIncidenciaController::class, 'show'])->name('incidencias.show');
    Route::patch('/incidencias/{incidencia}/cancelar', [ClienteIncidenciaController::class, 'cancelar'])->name('incidencias.cancelar');
});

// Rutas Técnico
Route::middleware(['auth', 'role:tecnico'])->prefix('tecnico')->name('tecnico.')->group(function () {
    Route::get('/', [TecnicoIncidenciaController::class, 'index'])->name('dashboard');
    Route::get('/incidencias/{incidencia}', [TecnicoIncidenciaController::class, 'show'])->name('incidencias.show');
    Route::patch('/incidencias/{incidencia}/estado', [TecnicoIncidenciaController::class, 'actualizarEstado'])->name('incidencias.actualizarEstado');
});

// Rutas Administrador (Persona 2)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => 'Panel Administrador - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});

// Rutas Empresa Gestora B2B (Persona 3)
Route::middleware(['auth', 'role:gestora'])->prefix('gestora')->name('gestora.')->group(function () {
    Route::get('/', fn() => 'Panel Empresa Gestora B2B - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});