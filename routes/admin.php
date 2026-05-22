<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\OrderController;

// Lista de pedidos
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Nuevo pedido
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

// Editar pedido
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
