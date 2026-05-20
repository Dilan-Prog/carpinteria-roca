<?php

use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Client\PedidoController as ClientPedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/prueba', function () {
    return 'Funciona correctamente';
});

// Rutas del Cliente
Route::get('/consultar', [ClientPedidoController::class, 'showForm'])->name('client.consultar.form');
Route::get('/consultar/resultado', [ClientPedidoController::class, 'consultar'])->name('client.consultar');
Route::post('/cancelar', [ClientPedidoController::class, 'cancelar'])->name('client.cancelar');

// Rutas del Admin
Route::prefix('admin')->group(function () {
    Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [AdminPedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [AdminPedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{id}/edit', [AdminPedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{id}', [AdminPedidoController::class, 'update'])->name('pedidos.update');
    Route::patch('/pedidos/{id}/cancelar', [AdminPedidoController::class, 'cancel'])->name('pedidos.cancel');
    Route::delete('/pedidos/{id}', [AdminPedidoController::class, 'destroy'])->name('pedidos.destroy');
});