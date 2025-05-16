<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Rutas para el CRUD de BD
// Proveedores
Route::resource('proveedores', ProveedorController::class);
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
// Productos
route::resource('productos', ProductoController::class);
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');



