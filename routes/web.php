<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\Backend\EmployeeManagementController;

// Protegemos la ruta para que solo usuarios logueados (auth) puedan entrar
Route::middleware(['auth'])->prefix('empleado')->group(function () {

// Esta ruta mostrará la pantalla de Figma
Route::get('/mis-pedidos', [EmployeeManagementController::class, 'index'])->name('empleado.pedidos');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::patch('/empleado/pedidos/{id}/estado', [EmployeeManagementController::class, 'updateStatus'])->name('empleado.pedidos.updateStatus');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
