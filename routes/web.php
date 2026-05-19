<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Backend\EmployeeManagementController;

// Protegemos la ruta para que solo usuarios logueados (auth) puedan entrar
Route::middleware(['auth'])->prefix('empleado')->group(function () {
    
    // Esta ruta mostrará la pantalla de Figma
    Route::get('/mis-pedidos', [EmployeeManagementController::class, 'index'])->name('empleado.pedidos');
    
});