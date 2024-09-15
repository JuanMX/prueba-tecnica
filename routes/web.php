<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InventarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registro', [LoginController::class, 'registro']);
Route::post('/registro', [LoginController::class, 'nuevoUsuario']);

Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/inventario', [InventarioController::class, 'index'])->middleware('auth');
Route::prefix('inventario')->group(function () {
    Route::get('/miinventario', [InventarioController::class, 'miInventario'])->middleware('auth');
    Route::post('/miinventario', [InventarioController::class, 'listarInventario'])->middleware('auth');
    Route::post('/miinventario-crear', [InventarioController::class, 'inventarioCrear'])->middleware('auth');
    Route::patch('/miinventario-editar', [InventarioController::class, 'inventarioEditar'])->middleware('auth');
    Route::delete('/miinventario-eliminar', [InventarioController::class, 'inventarioEliminar'])->middleware('auth');

    Route::get('/total', [InventarioController::class, 'vistaInventarioTotal'])->middleware('auth');
    Route::post('/total', [InventarioController::class, 'listarInventarioTotal'])->middleware('auth');
});


Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');