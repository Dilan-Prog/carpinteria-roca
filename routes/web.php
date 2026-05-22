<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\Client\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pedido', [ClientController::class, 'index'])->name('client.consultar');
Route::post('/pedido/cancelar', [ClientController::class, 'cancelar'])->name('client.cancelar');

require __DIR__.'/auth.php';
