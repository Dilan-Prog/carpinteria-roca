<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::where('assigned_to', Auth::id())->get();
        return view('employe.order.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
    // 1. Buscamos el pedido en la base de datos
    $order = Order::findOrFail($id);

    // 2. Definimos el orden exacto de nuestras etapas según el Figma
    $etapas = [
        'Compra de material',
        'Corte',
        'Armado',
        'Tapizado',
        'Acabado',
        'Entrega'
    ];

    // 3. Buscamos en qué posición (índice) está el estado actual
    $indiceActual = array_search($order->estado, $etapas);

    // 4. Si encontramos el estado y no es el último ("Entrega"), lo avanzamos
    if ($indiceActual !== false && $indiceActual < count($etapas) - 1) {
        $order->estado = $etapas[$indiceActual + 1];
        $order->save(); // Guardamos el cambio en la base de datos
    }

    // 5. Regresamos a la pantalla anterior
    return redirect()->back();
    }
}
