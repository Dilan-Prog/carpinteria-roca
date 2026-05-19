<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeManagementController extends Controller
{
    public function index()
    {
        
        $pedidos = Pedido::where('empleado_id', Auth::id())->get();
        return view('empleado.mis-pedidos', compact('pedidos'));
    }
}