<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Employee\OrderController ;

Route::get('/pedidos', [OrderController::class, 'index'])->name('empleado.pedidos');
Route::patch('/pedidos/{id}/estado', [OrderController::class, 'updateStatus'])->name('empleado.pedidos.updateStatus');
