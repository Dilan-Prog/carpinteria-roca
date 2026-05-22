<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Pedido</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .card-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #666;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .field .value {
            font-size: 14px;
            color: #1a1a1a;
            background-color: #fafafa;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-status-active {
            background-color: #e8f6ed;
            color: #2e7d32;
        }

        .badge-status-cancelled {
            background-color: #fde8e8;
            color: #e63946;
        }

        .badge-status-finished {
            background-color: #eeeeee;
            color: #6b6b6b;
        }

        .badge-inicio {
            background-color: #e8f4fd;
            color: #2196f3;
        }

        .badge-corte {
            background-color: #e8eef9;
            color: #3f51b5;
        }

        .badge-armado {
            background-color: #f3e8fd;
            color: #9c27b0;
        }

        .badge-lijado {
            background-color: #fdf0e8;
            color: #ff5722;
        }

        .badge-pintado {
            background-color: #fde8f0;
            color: #e91e63;
        }

        .badge-listo {
            background-color: #e8fdf0;
            color: #4caf50;
        }

        .badge-pendiente {
            background-color: #fdf8e8;
            color: #f0a500;
        }

        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            background-color: #e63946;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #c1121f;
        }
    </style>
</head>

<body>
    @php
        $activeStage = $order->productionStages->firstWhere('state', 'en_proceso');
        $stageClassMap = [
            'inicio' => 'badge-inicio',
            'corte' => 'badge-corte',
            'armado' => 'badge-armado',
            'lijado' => 'badge-lijado',
            'pintado' => 'badge-pintado',
            'listo_para_entregar' => 'badge-listo',
        ];
        $stageLabelMap = [
            'inicio' => 'Inicio',
            'corte' => 'Corte',
            'armado' => 'Armado',
            'lijado' => 'Lijado',
            'pintado' => 'Pintado',
            'listo_para_entregar' => 'Listo para entregar',
        ];
        $stageClass = $activeStage ? ($stageClassMap[$activeStage->stage] ?? 'badge-pendiente') : 'badge-pendiente';
        $stageLabel = $activeStage ? ($stageLabelMap[$activeStage->stage] ?? 'En proceso') : 'Sin etapa';

        $statusClassMap = [
            'active' => 'badge-status-active',
            'cancelled' => 'badge-status-cancelled',
            'finished' => 'badge-status-finished',
        ];
        $statusLabelMap = [
            'active' => 'Activo',
            'cancelled' => 'Cancelado',
            'finished' => 'Finalizado',
        ];
        $statusClass = $statusClassMap[$order->status] ?? 'badge-status-finished';
        $statusLabel = $statusLabelMap[$order->status] ?? 'Finalizado';
    @endphp

    <div class="card">
        <div class="card-header">
            <h2>Detalle del Pedido</h2>
        </div>

        <div class="field">
            <label>Codigo</label>
            <div class="value">{{ $order->order_code }}</div>
        </div>

        <div class="field">
            <label>Cliente</label>
            <div class="value">{{ $order->client_name }}</div>
        </div>

        <div class="field">
            <label>Telefono</label>
            <div class="value">{{ $order->client_phone }}</div>
        </div>

        <div class="field">
            <label>Descripcion</label>
            <div class="value">{{ $order->product_description }}</div>
        </div>

        <div class="field">
            <label>Costo total</label>
            <div class="value">${{ number_format($order->total_cost, 2, '.', ',') }}</div>
        </div>

        <div class="field">
            <label>Anticipo</label>
            <div class="value">${{ number_format($order->advance_payment, 2, '.', ',') }}</div>
        </div>

        <div class="field">
            <label>Saldo</label>
            <div class="value">${{ number_format($order->remaining_balance, 2, '.', ',') }}</div>
        </div>

        <div class="field">
            <label>Entrega estimada</label>
            <div class="value">{{ $order->estimated_delivery?->format('d/m/Y') ?? $order->estimated_delivery }}</div>
        </div>

        <div class="field">
            <label>Estado</label>
            <div class="value">
                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>
        </div>

        <div class="field">
            <label>Etapa actual</label>
            <div class="value">
                <span class="badge {{ $stageClass }}">{{ $stageLabel }}</span>
            </div>
        </div>

        <div class="footer">
            <a href="{{ route('admin.orders.index') }}" style="text-decoration: none;">
                <button class="btn-back" type="button">Volver</button>
            </a>
        </div>
    </div>
</body>

</html>
