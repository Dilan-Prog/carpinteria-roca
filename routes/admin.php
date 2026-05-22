<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\OrderController;

// Lista de pedidos
Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');

// Nuevo pedido
Route::get('/pedidos/crear', [OrderController::class, 'create'])->name('orders.create');
Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');

// Ver pedido
Route::get('/pedidos/{id}', [OrderController::class, 'show'])->name('orders.show');

// Editar pedido
Route::get('/pedidos/{id}/editar', [OrderController::class, 'edit'])->name('orders.edit');
Route::patch('/pedidos/{id}', [OrderController::class, 'update'])->name('orders.update');

// Cancelar y eliminar pedido
Route::patch('/pedidos/{id}/cancelar', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::delete('/pedidos/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
