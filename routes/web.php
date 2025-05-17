<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Autenticación
Auth::routes();

// Ruta después del login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// CRUD Proveedores
Route::resource('proveedores', ProveedorController::class);

// CRUD Productos
Route::resource('productos', ProductoController::class);
