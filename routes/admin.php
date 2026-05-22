<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\OrderController;

// Lista de pedidos
Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');

// Nuevo pedido
Route::get('/pedidos/crear', [OrderController::class, 'create'])->name('orders.create');

// Editar pedido
Route::get('/pedidos/{id}/editar', [OrderController::class, 'edit'])->name('orders.edit');
