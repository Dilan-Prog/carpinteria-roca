<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 170px;
            background-color: #ffffff;
            border-right: 1px solid #e8e8e8;
            display: flex;
            flex-direction: column;
            padding: 16px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow: hidden;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 0 12px 16px 12px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-logo .logo-icono {
            min-width: 32px;
            height: 32px;
            background-color: #e63946;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-logo .logo-texto h2 {
            font-size: 16px;
            font-weight: 800;
            color: #e63946;
        }

        .sidebar-logo .logo-texto p {
            font-size: 11px;
            color: #888;
        }

        .sidebar-menu {
            flex: 1;
            padding: 0 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            text-decoration: none;
            transition: background-color 0.2s;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-menu a span {
            opacity: 1;
        }

        .sidebar-menu a:hover {
            background-color: #f5f5f5;
            color: #e63946;
        }

        .sidebar-menu a.activo {
            background-color: #fff0f1;
            color: #e63946;
        }

        .sidebar-footer {
            padding: 0 8px;
            border-top: 1px solid #f0f0f0;
            padding-top: 12px;
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #888;
            text-decoration: none;
            transition: background-color 0.2s;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-footer a span {
            opacity: 1;
        }

        .sidebar-footer a:hover {
            background-color: #f5f5f5;
            color: #e63946;
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #888;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            white-space: nowrap;
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar-logout:hover {
            background-color: #f5f5f5;
            color: #e63946;
        }

        /* ── CONTENIDO PRINCIPAL ── */
        .contenido {
            margin-left: 170px;
            padding: 32px;
            flex: 1;
        }

        .contenido-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .contenido-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .contenido-header p {
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }

        .btn-nuevo {
            background-color: #e63946;
            color: #fff;
            border: none;
            padding: 11px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .btn-nuevo:hover {
            background-color: #c1121f;
        }

        /* ── BUSCADOR ── */
        .buscador {
            position: relative;
            margin-bottom: 20px;
            width: 340px;
        }

        .buscador input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 13px;
            color: #555;
            background-color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .buscador input:focus {
            outline: none;
            border-color: #e63946;
        }

        .buscador svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        /* ── TABLA ── */
        .tabla-contenedor {
            background-color: #fff;
            border-radius: 12px;
            border: 1px solid #e8e8e8;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 1px solid #f0f0f0;
        }

        thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #aaa;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #f9f9f9;
            transition: background-color 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #fafafa;
        }

        tbody td {
            padding: 16px;
            font-size: 13px;
            color: #333;
            vertical-align: middle;
        }

        .codigo {
            font-weight: 700;
            color: #1a1a1a;
        }

        .cliente-nombre {
            font-weight: 600;
            color: #1a1a1a;
        }

        .cliente-tel {
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }

        .descripcion {
            max-width: 260px;
            color: #555;
            line-height: 1.4;
        }

        .alerta {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .alerta-exito {
            background-color: #e8f6ed;
            color: #2e7d32;
            border-color: #cfead6;
        }

        .alerta-error {
            background-color: #fde8e8;
            color: #e63946;
            border-color: #f5caca;
        }

        /* ── BADGES DE ESTADO ── */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
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

        .badge-pendiente {
            background-color: #fdf8e8;
            color: #f0a500;
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

        .badge-cancelado {
            background-color: #fde8e8;
            color: #e63946;
        }

        /* ── ACCIONES ── */
        .acciones {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .acciones form {
            margin: 0;
        }

        .btn-accion {
            border: 1px solid transparent;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-ver {
            color: #1a73e8;
            border-color: #d6e4ff;
            background-color: #f3f7ff;
        }

        .btn-editar {
            color: #2e7d32;
            border-color: #cfead6;
            background-color: #eefaf1;
        }

        .btn-cancelar {
            color: #f0a500;
            border-color: #f6e2b6;
            background-color: #fff7e1;
        }

        .btn-eliminar {
            color: #e63946;
            border-color: #f5caca;
            background-color: #fff0f1;
        }

        .sin-registros {
            text-align: center;
            padding: 24px;
            color: #888;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icono">R</div>
            <div class="logo-texto">
                <h2>Roca</h2>
                <p>Panel Admin</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="/admin/orders" class="activo">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    flex-shrink="0" style="flex-shrink:0">
                    <path
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Mis Pedidos</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        style="flex-shrink:0">
                        <path
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido">

        @if (session('success'))
            <div class="alerta alerta-exito">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alerta alerta-error">{{ session('error') }}</div>
        @endif

        <!-- Header -->
        <div class="contenido-header">
            <div>
                <h2>Gestión de Pedidos</h2>
                <p>{{ $orders->total() }} pedidos en total</p>
            </div>
            <a href="{{ route('admin.orders.create') }}" style="text-decoration: none;">
                <button class="btn-nuevo">+ Nuevo Pedido</button>
            </a>
        </div>

        <!-- Buscador -->
        <div class="buscador">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input type="text" placeholder="Buscar por código, cliente o descripción...">
        </div>

        <!-- Tabla -->
        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Costo Total</th>
                        <th>Anticipo</th>
                        <th>Saldo</th>
                        <th>Entrega Estimada</th>
                        <th>Estado</th>
                        <th>Etapa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
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
                        <tr>
                            <td class="codigo">{{ $order->order_code }}</td>
                            <td class="cliente-nombre">{{ $order->client_name }}</td>
                            <td class="cliente-tel">{{ $order->client_phone }}</td>
                            <td>${{ number_format($order->total_cost, 2, '.', ',') }}</td>
                            <td>${{ number_format($order->advance_payment, 2, '.', ',') }}</td>
                            <td>${{ number_format($order->remaining_balance, 2, '.', ',') }}</td>
                            <td>{{ $order->estimated_delivery?->format('d/m/Y') ?? $order->estimated_delivery }}</td>
                            <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td><span class="badge {{ $stageClass }}">{{ $stageLabel }}</span></td>
                            <td>
                                <div class="acciones">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-accion btn-ver">Ver</a>
                                    @if ($order->canBeEdited())
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-accion btn-editar">Editar</a>
                                    @endif
                                    @if ($order->canBeCancelled())
                                        <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-accion btn-cancelar">Cancelar</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-accion btn-eliminar">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="sin-registros" colspan="10">No hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $orders->links() }}
        </div>

    </main>
</body>

</html>
