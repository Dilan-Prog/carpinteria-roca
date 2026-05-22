<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;                      // ← era: Pedido
use App\Models\ProductionStage;            // ← nuevo: para crear las etapas al registrar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        // ← era: Pedido::orderBy(...)
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // ← eran: nombre_cliente, telefono, descripcion_producto, anticipo
            'client_name'         => 'required|string|max:150',
            'client_phone'        => 'required|string|max:20',
            'product_description' => 'required|string',
            'total_cost'          => 'required|numeric|min:0',
            'advance_payment'     => 'required|numeric|min:0',
            'estimated_delivery'  => 'required|date',
        ], [
            'client_phone.required' => 'El teléfono del cliente es obligatorio.',
            'client_phone.max'      => 'El teléfono no puede superar 20 caracteres.',
        ]);

        // Regla de negocio: anticipo mínimo del 50%
        if ($request->advance_payment < ($request->total_cost * 0.5)) {
            return back()
                ->withErrors(['advance_payment' => 'El anticipo debe ser al menos el 50% del costo total.'])
                ->withInput();
        }

        // Generar order_code único: PED-000001, PED-000002, etc.
        $lastId = Order::max('id') ?? 0;
        $orderCode = 'PED-' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($request, $orderCode) {

            $order = Order::create([
                // ← era: nombre_cliente, telefono, descripcion_producto, etc.
                'order_code'          => $orderCode,
                'created_by'          => Auth::id(),   // ← nuevo: admin que registra
                'assigned_to'         => null,          // ← se asigna después
                'client_name'         => $request->client_name,
                'client_phone'        => $request->client_phone,
                'product_description' => $request->product_description,
                'total_cost'          => $request->total_cost,
                'advance_payment'     => $request->advance_payment,
                'remaining_balance'   => $request->total_cost - $request->advance_payment,
                'estimated_delivery'  => $request->estimated_delivery,
                'status'              => 'active',      // ← era: 'estado' => 'inicio'
            ]);

            // ← nuevo: crear las 6 etapas automáticamente al registrar el pedido
            $stages = [
                'inicio',
                'corte',
                'armado',
                'lijado',
                'pintado',
                'listo_para_entregar',
            ];

            foreach ($stages as $index => $stage) {
                ProductionStage::create([
                    'order_id'    => $order->id,
                    'stage'       => $stage,
                    'stage_order' => $index + 1,
                    // La primera etapa arranca en 'en_proceso', las demás 'pendiente'
                    'state'       => $index === 0 ? 'en_proceso' : 'pendiente',
                    'started_at'  => $index === 0 ? now() : null,
                ]);
            }
        });

        return redirect()->route('admin.orders.index')
                         ->with('success', 'El pedido se registró exitosamente.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);

        // ← era: $pedido->puedeEditarse()
        // La regla: no editar después de que 'armado' esté terminado
        if (!$order->canBeEdited()) {
            return redirect()->route('admin.orders.index')
                             ->with('error', 'No se puede editar este pedido porque ya pasó la etapa de armado.');
        }

        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->canBeEdited()) {
            return back()->with('error', 'No se puede editar este pedido porque ya pasó la etapa de armado.');
        }

        $request->validate([
            'client_name'         => 'required|string|max:150',
            'client_phone'        => 'required|string|max:20',
            'product_description' => 'required|string',
            'total_cost'          => 'required|numeric|min:0',
            'advance_payment'     => 'required|numeric|min:0',
            'estimated_delivery'  => 'required|date',
        ]);

        // Regla de negocio: anticipo mínimo del 50%
        if ($request->advance_payment < ($request->total_cost * 0.5)) {
            return back()
                ->withErrors(['advance_payment' => 'El anticipo debe ser al menos el 50% del costo total.'])
                ->withInput();
        }

        $order->update([
            'client_name'         => $request->client_name,
            'client_phone'        => $request->client_phone,
            'product_description' => $request->product_description,
            'total_cost'          => $request->total_cost,
            'advance_payment'     => $request->advance_payment,
            'remaining_balance'   => $request->total_cost - $request->advance_payment,
            'estimated_delivery'  => $request->estimated_delivery,
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'El pedido se actualizó correctamente.');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // ← era: $pedido->puedeCancelarse()
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Solo se pueden cancelar pedidos dentro de las primeras 48 horas.');
        }

        $order->update([
            'status'       => 'cancelled',        // ← era: estado = 'cancelado'
            'cancelled_at' => now(),              // ← nuevo: registrar cuándo se canceló
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'El pedido ha sido cancelado correctamente.');
    }

    // ⚠️  ELIMINAR: El DFR no contempla eliminación permanente de pedidos.
    //     La bitácora debe ser inalterable (RNF-CONF-05).
    //     Se mantiene el método pero protegido — evalúa si realmente lo necesitas.
    public function destroy($id)
    {
        // Si decides quitarlo, elimina este método y su ruta.
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pedido eliminado permanentemente.');
    }
}
