<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpintería Ro-Ca | Seguimiento de pedidos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            padding: 1rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .container {
            max-width: 42rem;
            margin: 0 auto;
            padding: 2rem 0;
        }

        .brand-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #E53935;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-body {
            padding: 2rem;
        }

        .card-body h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
        }

        /* Alerts */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.375rem;
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color: white;
        }

        .form-control:focus {
            border-color: #E53935;
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-primary {
            width: 100%;
            background-color: #E53935;
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #c62828;
        }

        /* Order details */
        .order-details {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .detail-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            text-align: right;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .badge-purple {
            background-color: #f3e8ff;
            color: #7e22ce;
        }

        .badge-green {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-red {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .badge-gray {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        /* Progress steps */
        .progress-section {
            margin-bottom: 2rem;
        }

        .progress-section h3 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
        }

        .steps {
            display: flex;
            flex-direction: column;
        }

        .step {
            display: flex;
            align-items: flex-start;
        }

        .step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .step-circle {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .step-circle.completed {
            background-color: #22c55e;
            color: white;
        }

        .step-circle.current {
            background-color: #E53935;
            color: white;
        }

        .step-circle.pending {
            background-color: #d1d5db;
            color: #6b7280;
        }

        .step-line {
            width: 2px;
            height: 2rem;
            margin-top: 0.25rem;
        }

        .step-line.completed {
            background-color: #22c55e;
        }

        .step-line.pending {
            background-color: #d1d5db;
        }

        .step-content {
            flex: 1;
            padding-top: 0.375rem;
            padding-bottom: 1rem;
        }

        .step-name {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .step-name.current {
            font-weight: 600;
            color: #111827;
        }

        /* Info box */
        .info-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            font-size: 0.875rem;
            color: #1e40af;
        }

        /* Cancellation section */
        .cancel-section {
            border-top: 1px solid #e5e7eb;
            padding-top: 1.5rem;
        }

        .cancel-section h3 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.75rem;
        }

        .btn-cancel-disabled {
            width: 100%;
            border: 2px solid #d1d5db;
            color: #9ca3af;
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: not-allowed;
            font-size: 0.875rem;
        }

        .btn-cancel-active {
            width: 100%;
            border: 2px solid #E53935;
            color: #E53935;
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
            font-size: 0.875rem;
        }

        .btn-cancel-active:hover {
            background-color: #E53935;
            color: white;
        }

        .cancel-note {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        /* Back link */
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 1.5rem 0;
        }

        .back-link {
            display: block;
            text-align: center;
            color: #E53935;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-title">
            <h1>Roca</h1>
        </div>

        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if(!isset($order))
                    <h2>Estado de tu pedido</h2>
                    <form method="GET" action="{{ route('client.consultar') }}">
                        <div class="form-group">
                            <label class="form-label">Código del pedido</label>
                            <input type="text" name="codigo" class="form-control"
                                   placeholder="Ejemplo: ORD-2026-001" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Teléfono registrado</label>
                            <input type="tel" name="telefono" class="form-control"
                                   placeholder="El número que usaste al hacer tu pedido" required>
                        </div>
                        <button type="submit" class="btn-primary">Consultar mi pedido</button>
                    </form>
                @endif

                @isset($order)
                    @php
                        $stages = $order->productionStages->sortBy('stage_order');

                        $etiquetas = [
                            'inicio'               => 'Inicio',
                            'corte'                => 'Corte',
                            'armado'               => 'Armado',
                            'lijado'               => 'Lijado',
                            'pintado'              => 'Pintado',
                            'listo_para_entregar'  => 'Listo para entregar',
                        ];

                        $actual = $stages->firstWhere('state', 'en_proceso');

                        $labelEstado = match ($order->status) {
                            'active'    => ($actual ? ($etiquetas[$actual->stage] ?? 'En proceso') : 'En proceso'),
                            'cancelled' => 'Cancelado',
                            'finished'  => 'Listo para entregar',
                            default     => 'En proceso',
                        };

                        $badgeClase = match ($order->status) {
                            'cancelled' => 'badge-red',
                            'finished'  => 'badge-green',
                            default     => 'badge-purple',
                        };
                    @endphp

                    <h2>Estado de tu pedido</h2>

                    <div class="order-details">
                        <div class="detail-row">
                            <span class="detail-label">Código:</span>
                            <span class="detail-value">{{ $order->order_code }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Estado actual:</span>
                            <span class="badge {{ $badgeClase }}">{{ $labelEstado }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Cliente:</span>
                            <span class="detail-value">{{ $order->client_name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Fecha estimada de entrega:</span>
                            <span class="detail-value">
                                {{ $order->estimated_delivery?->format('d/m/Y') ?? 'Por definir' }}
                            </span>
                        </div>
                    </div>

                    <div class="progress-section">
                        <h3>Progreso de tu pedido</h3>
                        <div class="steps">
                            @foreach($stages as $stage)
                                @php
                                    $isCompleted = $stage->state === 'terminado';
                                    $isCurrent   = $stage->state === 'en_proceso';
                                    $circleClass = $isCompleted ? 'completed' : ($isCurrent ? 'current' : 'pending');
                                    $lineClass   = $isCompleted ? 'completed' : 'pending';
                                @endphp
                                <div class="step">
                                    <div class="step-indicator">
                                        <div class="step-circle {{ $circleClass }}">
                                            @if($isCompleted)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                                    <path d="m9 11 3 3L22 4"></path>
                                                </svg>
                                            @else
                                                {{ $loop->index + 1 }}
                                            @endif
                                        </div>
                                        @if(!$loop->last)
                                            <div class="step-line {{ $lineClass }}"></div>
                                        @endif
                                    </div>
                                    <div class="step-content">
                                        <p class="step-name {{ $isCurrent ? 'current' : '' }}">
                                            {{ $etiquetas[$stage->stage] ?? $stage->stage }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="info-box">
                        <p>Vista de solo lectura. No puedes modificar ningún dato.</p>
                    </div>

                    <div class="cancel-section">
                        <h3>Cancelación de pedido</h3>
                        @if($order->canBeCancelled() && $order->status !== 'cancelled')
                            <form method="POST" action="{{ route('client.cancelar') }}"
                                  onsubmit="return confirm('¿Estás seguro de que quieres cancelar este pedido? Se te reembolsará el anticipo.')">
                                @csrf
                                <input type="hidden" name="codigo" value="{{ $order->order_code }}">
                                <input type="hidden" name="telefono" value="{{ $order->client_phone }}">
                                <button type="submit" class="btn-cancel-active">Cancelar pedido</button>
                            </form>
                            <p class="cancel-note">Puedes cancelar tu pedido dentro de las primeras 48 horas.</p>
                        @else
                            <button disabled class="btn-cancel-disabled">Cancelación no disponible</button>
                            <p class="cancel-note">El periodo de cancelación ha vencido o el pedido ya está en proceso avanzado.</p>
                        @endif
                    </div>

                    <div class="divider"></div>

                    <a href="{{ route('client.consultar') }}" class="back-link">← Consultar otro pedido</a>
                @endisset

            </div>
        </div>
    </div>
</body>
</html>
