<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f6f9;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        /* Sidebar moderna */
        .sidebar-modern {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-modern h5 {
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .sidebar-modern .nav-link {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.3s ease;
        }

        .sidebar-modern .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        /* Contenido principal */
        .main-content {
            padding: 24px 32px;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        /* Botón nuevo pedido */
        .btn-primary-modern {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 40px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        }

        /* Tabla moderna */
        .table-modern {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .table-modern thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-modern tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-modern tbody tr:hover {
            background: #fef9e8;
            transition: background 0.3s ease;
        }

        /* Badge de estado */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background: #e0f2fe;
            color: #0284c7;
        }

        .badge-canceled {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Botones de acción (solo íconos) */
        .action-icons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .action-icon {
            color: #64748b;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .action-icon:hover {
            color: #1e293b;
            transform: scale(1.1);
        }

        .action-icon.edit:hover {
            color: #f59e0b;
        }

        .action-icon.cancel:hover {
            color: #ef4444;
        }

        .action-icon.delete:hover {
            color: #dc2626;
        }

        /* Paginación */
        .pagination-modern {
            margin-top: 24px;
        }

        /* Alertas */
        .alert-modern {
            border-radius: 16px;
            border: none;
            padding: 14px 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }
            .table-modern {
                font-size: 0.8rem;
            }
            .action-icons {
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar-modern vh-100 p-3">
                <h5 class="text-white mb-4">Carpintería Ro-Ca</h5>
                <hr class="text-white-50">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('pedidos.index') }}">
                            <i class="fas fa-box me-2"></i> Pedidos
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="page-header">
                    <h1><i class="fas fa-clipboard-list me-2"></i>Gestión de Pedidos</h1>
                    <a href="{{ route('pedidos.create') }}" class="btn btn-primary-modern">
                        <i class="fas fa-plus me-2"></i>Nuevo Pedido
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Producto</th>
                                <th>Costo Total</th>
                                <th>Anticipo</th>
                                <th>Estado</th>
                                <th>Fecha Entrega</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                            <tr>
                                <td><strong>#{{ $pedido->id }}</strong></td>
                                <td>{{ $pedido->nombre_cliente }}</td>
                                <td>{{ $pedido->telefono }}</td>
                                <td>{{ Str::limit($pedido->descripcion_producto, 30) }}</td>
                                <td>${{ number_format($pedido->costo_total, 2) }}</td>
                                <td>${{ number_format($pedido->anticipo, 2) }}</td>
                                <td>
                                    @if($pedido->estado == 'cancelado')
                                        <span class="badge-status badge-canceled">
                                            <i class="fas fa-ban"></i> Cancelado
                                        </span>
                                    @else
                                        <span class="badge-status badge-active">
                                            <i class="fas fa-spinner"></i> {{ ucfirst($pedido->estado) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $pedido->fecha_estimada_entrega }}</td>
                                <td class="action-icons">
                                    @if($pedido->estado != 'cancelado')
                                        <a href="{{ route('pedidos.edit', $pedido) }}" class="action-icon edit" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endif

                                    @if($pedido->estado != 'cancelado')
                                        <form action="{{ route('pedidos.cancel', $pedido) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-icon cancel" onclick="return confirm('¿Cancelar este pedido?')" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($pedido->estado == 'cancelado')
                                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon delete" onclick="return confirm('¿Eliminar permanentemente?')" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No hay pedidos registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-modern">
                    {{ $pedidos->links() }}
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>