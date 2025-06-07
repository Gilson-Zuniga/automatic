<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TipoArticuloController;
use App\Http\Controllers\PerfilEmpresaController;
use App\Http\Controllers\FacturaProveedorController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\FacturaClienteController;
use App\Http\Controllers\Auth\ClienteRegisterController;
use App\Http\Controllers\EcommerceController;

use Illuminate\Support\Facades\Auth;
// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Autenticación
Auth::routes();

// Registro de clientes
Route::get('/registro-cliente', [ClienteRegisterController::class, 'showRegistrationForm'])->name('cliente.register');
Route::post('/registro-cliente', [ClienteRegisterController::class, 'register']);

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
Route::resource('facturas_proveedores', FacturaProveedorController::class)
    ->parameters(['facturas_proveedores' => 'factura']);
Route::get('facturas_proveedores/{factura}/pdf', [FacturaProveedorController::class, 'downloadPdf'])
    ->name('facturas_proveedores.pdf');

// Rutas para el Inventario
Route::get('/inventario', [App\Http\Controllers\InventarioController::class, 'index'])->name('inventario.index');


// Rutas para el Catalogo
Route::resource('catalogo', CatalogoController::class)->except(['show']);

// Rutas para Factura Venta
Route::prefix('facturas_clientes')->name('facturas_clientes.')->group(function () {

    // Mostrar listado de facturas
    Route::get('/', [FacturaClienteController::class, 'index'])->name('index');

    // Mostrar formulario de creación
    Route::get('/create', [FacturaClienteController::class, 'create'])->name('create');

    // Almacenar factura nueva
    Route::post('/', [FacturaClienteController::class, 'store'])->name('store');

    // Mostrar detalle de una factura (opcional)
    Route::get('/{factura}', [FacturaClienteController::class, 'show'])->name('show');

    // Eliminar una factura
    Route::delete('/{factura}', [FacturaClienteController::class, 'destroy'])->name('destroy');
    // Ruta adicional para descargar el PDF
    Route::get('/{factura}/descargar', [FacturaClienteController::class, 'descargarPDF'])->name('descargarPDF');
});

Route::get('/ecommerce', [EcommerceController::class, 'index'])->name('ecommerce');







