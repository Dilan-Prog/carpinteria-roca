<?php

use Illuminate\Support\Facades\Route;

// Lista de pedidos
Route::get('/admin/orders', function () {
    return view('admin.order.index');
});

// Nuevo pedido
Route::get('/admin/orders/create', function () {
    return view('admin.order.create');
});

// Editar pedido
Route::get('/admin/orders/{id}/edit', function ($id) {
    return view('admin.order.edit');
});
