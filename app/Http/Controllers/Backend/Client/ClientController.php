<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $order = null;

        if ($request->filled('codigo') && $request->filled('telefono')) {
            $order = Order::where('order_code', $request->codigo)
                ->where('client_phone', $request->telefono)
                ->with(['productionStages' => function ($query) {
                    $query->orderBy('stage_order');
                }])
                ->first();

            if (!$order) {
                return back()->with('error', 'Datos de acceso incorrectos. Verifica tu codigo y telefono.');
            }

            session(['client_order_id' => $order->id]);
        }

        return view('client.index', compact('order'));
    }

    public function cancelar(Request $request)
    {
        $order = Order::where('order_code', $request->codigo)
            ->where('client_phone', $request->telefono)
            ->where('status', 'active')
            ->firstOrFail();

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Solo puedes cancelar tu pedido dentro de las primeras 48 horas.');
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Tu pedido ha sido cancelado correctamente. Se te reembolsara el anticipo.');
    }
}
