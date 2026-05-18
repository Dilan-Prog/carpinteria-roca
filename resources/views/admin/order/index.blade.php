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
            width: 56px;
            background-color: #ffffff;
            border-right: 1px solid #e8e8e8;
            display: flex;
            flex-direction: column;
            padding: 16px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            transition: width 0.3s ease;
            overflow: hidden;
            z-index: 100;
        }

        .sidebar:hover {
            width: 170px;
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
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar-logo .logo-texto p {
            font-size: 11px;
            color: #888;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar:hover .logo-texto h2,
        .sidebar:hover .logo-texto p {
            opacity: 1;
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
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar:hover .sidebar-menu a span {
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
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar:hover .sidebar-footer a span {
            opacity: 1;
        }

        .sidebar-footer a:hover {
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

        /* ── BADGES DE ESTADO ── */
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
            gap: 10px;
            align-items: center;
        }

        .btn-editar,
        .btn-eliminar {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-editar {
            color: #2196f3;
        }

        .btn-editar:hover {
            background-color: #e8f4fd;
        }

        .btn-eliminar {
            color: #e63946;
        }

        .btn-eliminar:hover {
            background-color: #fff0f1;
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
            <a href="#">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="flex-shrink:0">
                    <path
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido">

        <!-- Header -->
        <div class="contenido-header">
            <div>
                <h2>Gestión de Pedidos</h2>
                <p>4 pedidos en total</p>
            </div>
            <a href="/admin/orders/create" style="text-decoration: none;">
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
                        <th>Descripción</th>
                        <th>Costo Total</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th>Entrega</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="codigo">ORD-2026-001</td>
                        <td>
                            <div class="cliente-nombre">María González</div>
                            <div class="cliente-tel">5551234567</div>
                        </td>
                        <td class="descripcion">Recámara King Size completa, incluye cabecera tapizada en tela gris,
                            buró con 3 cajones</td>
                        <td>$45,000</td>
                        <td>$22,500</td>
                        <td><span class="badge badge-inicio">Inicio</span></td>
                        <td>14/05/2026</td>
                        <td>
                            <div class="acciones">
                                <a href="/admin/orders/1/edit" style="text-decoration: none;">
                                    <button class="btn-editar" title="Editar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
                                <form method="POST" action="/admin/orders/1"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar" title="Eliminar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="codigo">ORD-2026-002</td>
                        <td>
                            <div class="cliente-nombre">Carlos Ramírez</div>
                            <div class="cliente-tel">5559876543</div>
                        </td>
                        <td class="descripcion">Sala de 3 piezas (sofá, loveseat y sillón) en tela beige con estructura
                            de madera</td>
                        <td>$38,000</td>
                        <td>$19,000</td>
                        <td><span class="badge badge-lijado">Lijado</span></td>
                        <td>19/05/2026</td>
                        <td>
                            <div class="acciones">
                                <a href="editar-pedido.html" style="text-decoration: none;">
                                    <button class="btn-editar" title="Editar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
                                <form method="POST" action="/admin/orders/1"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar" title="Eliminar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="codigo">ORD-2026-003</td>
                        <td>
                            <div class="cliente-nombre">Ana Martínez</div>
                            <div class="cliente-tel">5554567890</div>
                        </td>
                        <td class="descripcion">Recámara King Size completa, Tocador con espejo, 2 burós laterales</td>
                        <td>$52,000</td>
                        <td>$26,000</td>
                        <td><span class="badge badge-listo">Listo para entregar</span></td>
                        <td>19/04/2026</td>
                        <td>
                            <div class="acciones">
                                <a href="editar-pedido.html" style="text-decoration: none;">
                                    <button class="btn-editar" title="Editar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
                                <form method="POST" action="/admin/orders/1"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar" title="Eliminar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="codigo">ORD-2026-004</td>
                        <td>
                            <div class="cliente-nombre">Roberto López</div>
                            <div class="cliente-tel">5552223333</div>
                        </td>
                        <td class="descripcion">Comedor de 6 sillas con mesa extensible de madera de pino</td>
                        <td>$28,000</td>
                        <td>$14,000</td>
                        <td><span class="badge badge-pintado">Pintado</span></td>
                        <td>09/05/2026</td>
                        <td>
                            <div class="acciones">
                                <a href="editar-pedido.html" style="text-decoration: none;">
                                    <button class="btn-editar" title="Editar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
                                <form method="POST" action="/admin/orders/1"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar" title="Eliminar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

</body>

</html>