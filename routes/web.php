<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TipoArticuloController;
use App\Http\Controllers\PerfilEmpresaController;
use App\Http\Controllers\FacturaProveedorController;


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

// CRUD Categorías
Route::resource('categorias', CategoriaController::class);

// CRUD Tipos de Artículos
Route::resource('tipoArticulos', TipoArticuloController::class);

// Rutas para la gestión de perfiles de empresa
Route::resource('perfilEmpresas', PerfilEmpresaController::class);

// Rutas para Facturas de Proveedores


Route::resource('facturas_proveedores', FacturaProveedorController::class);
Route::get('facturas_proveedores/{factura}/pdf', [FacturaProveedorController::class, 'downloadPdf'])
    ->name('facturas_proveedores.pdf');

// Rutas para el Inventario
Route::get('/inventario', [App\Http\Controllers\InventarioController::class, 'index'])->name('inventario.index');




