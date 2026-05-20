<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('admin.pedidos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits_between:8,15',
            'descripcion_producto' => 'required|string',
            'costo_total' => 'required|numeric|min:0',
            'anticipo' => 'required|numeric|min:0',
            'fecha_estimada_entrega' => 'required|date',
        ], [
            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'telefono.digits_between' => 'El teléfono debe tener entre 8 y 15 dígitos.',
        ]);

        if ($request->anticipo < ($request->costo_total * 0.5)) {
            return back()->withErrors(['anticipo' => 'El anticipo debe ser al menos el 50% del costo total'])
                         ->withInput();
        }

        Pedido::create([
            'nombre_cliente' => $request->nombre_cliente,
            'telefono' => $request->telefono,
            'descripcion_producto' => $request->descripcion_producto,
            'costo_total' => $request->costo_total,
            'anticipo' => $request->anticipo,
            'fecha_estimada_entrega' => $request->fecha_estimada_entrega,
            'estado' => 'inicio'
        ]);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido registrado exitosamente');
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);

        if (!$pedido->puedeEditarse()) {
            return redirect()->route('pedidos.index')
                             ->with('error', 'No se puede editar este pedido porque ya pasó la etapa de armado');
        }

        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        if (!$pedido->puedeEditarse()) {
            return back()->with('error', 'No se puede editar este pedido porque ya pasó la etapa de armado');
        }

        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits_between:8,15',
            'descripcion_producto' => 'required|string',
            'costo_total' => 'required|numeric|min:0',
            'anticipo' => 'required|numeric|min:0',
            'fecha_estimada_entrega' => 'required|date',
        ]);

        $pedido->update([
            'nombre_cliente' => $request->nombre_cliente,
            'telefono' => $request->telefono,
            'descripcion_producto' => $request->descripcion_producto,
            'costo_total' => $request->costo_total,
            'anticipo' => $request->anticipo,
            'fecha_estimada_entrega' => $request->fecha_estimada_entrega,
        ]);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido actualizado correctamente');
    }

    // ✅ CANCELAR: Solo cambia el estado a 'cancelado'
    public function cancel($id)
    {
        $pedido = Pedido::findOrFail($id);

        if (!$pedido->puedeCancelarse()) {
            return back()->with('error', 'Solo se pueden cancelar pedidos dentro de las primeras 48 horas');
        }

        $pedido->estado = 'cancelado';
        $pedido->save();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido cancelado. Usa 🗑️ para eliminarlo.');
    }

    // ✅ ELIMINAR: Borra permanentemente
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido eliminado permanentemente.');
    }
}