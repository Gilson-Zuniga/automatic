<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('proveedores', ProveedorController::class);
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');



