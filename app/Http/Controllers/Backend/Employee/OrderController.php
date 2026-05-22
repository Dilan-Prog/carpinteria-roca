<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductionStage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('productionStages')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('employe.order.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $stage = ProductionStage::where('id', $id)
            ->where('state', 'en_proceso')
            ->first();

        if (!$stage) {
            return back()->with('error', 'No es posible avanzar. Debe completar la etapa anterior primero.');
        }

        $order = $stage->order;
        if (!$order || $order->status !== 'active') {
            return back()->with('error', 'No es posible avanzar. El pedido no esta disponible para cambios.');
        }

        if ($stage->stage_order > 1) {
            $previousStage = ProductionStage::where('order_id', $order->id)
                ->where('stage_order', $stage->stage_order - 1)
                ->first();

            if (!$previousStage || $previousStage->state !== 'terminado') {
                return back()->with('error', 'No es posible avanzar. Debe completar la etapa anterior primero.');
            }
        }

        DB::transaction(function () use ($request, $stage, $order) {
            $stage->update([
                'state' => 'terminado',
                'finished_at' => now(),
            ]);

            $nextStage = ProductionStage::where('order_id', $order->id)
                ->where('stage_order', $stage->stage_order + 1)
                ->first();

            if ($nextStage) {
                $nextStage->update([
                    'state' => 'en_proceso',
                    'started_at' => now(),
                ]);
            } else {
                $order->update([
                    'status' => 'finished',
                ]);
            }

            $stageLabels = [
                'inicio' => 'Inicio',
                'corte' => 'Corte',
                'armado' => 'Armado',
                'lijado' => 'Lijado',
                'pintado' => 'Pintado',
                'listo_para_entregar' => 'Listo para entregar',
            ];

            DB::table('audit_log')->insert([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'action' => 'stage_advanced',
                'description' => 'El empleado avanzo la etapa ' . ($stageLabels[$stage->stage] ?? $stage->stage) . ' del pedido ' . $order->order_code . '.',
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        });

        return back()->with('success', 'La etapa se avanzo correctamente.');
    }
}
