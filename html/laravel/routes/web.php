<?php

use App\Http\Controllers\AuthController;
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

// Rutas protegidas por rol (se ampliarán en cada módulo)
Route::middleware(['auth', 'role:particular'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', fn() => 'Panel Cliente Particular - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});

Route::middleware(['auth', 'role:tecnico'])->prefix('tecnico')->name('tecnico.')->group(function () {
    Route::get('/', fn() => 'Panel Técnico - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => 'Panel Administrador - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});

Route::middleware(['auth', 'role:gestora'])->prefix('gestora')->name('gestora.')->group(function () {
    Route::get('/', fn() => 'Panel Empresa Gestora B2B - Sesión iniciada como ' . Auth::user()->nombre)->name('dashboard');
});