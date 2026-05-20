<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Mostrar formulario de consulta
    public function showForm()
    {
        return view('client.index');
    }

    // Consultar pedido (sin autenticación)
    public function consultar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|exists:pedidos,id',
            'telefono' => 'required'
        ]);

        $pedido = Pedido::where('id', $request->codigo)
                        ->where('telefono', $request->telefono)
                        ->first();

        if (!$pedido) {
            return back()->with('error', 'Datos de acceso incorrectos');
        }

        return view('client.index', compact('pedido'));
    }

    // Cancelar pedido (cliente)
    public function cancelar(Request $request)
    {
        $pedido = Pedido::where('id', $request->codigo)
                        ->where('telefono', $request->telefono)
                        ->first();

        if (!$pedido) {
            return back()->with('error', 'Pedido no encontrado');
        }

        if (!$pedido->puedeCancelarse()) {
            return back()->with('error', 'Solo se pueden cancelar pedidos dentro de las primeras 48 horas');
        }

        if ($pedido->estado == 'cancelado') {
            return back()->with('error', 'Este pedido ya está cancelado');
        }

        $pedido->estado = 'cancelado';
        $pedido->save();

        return redirect()->route('client.consultar.form')
                         ->with('success', 'Pedido cancelado correctamente. Se aplica reembolso del anticipo.');
    }
}