<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Carpintería Ro-Ca | Seguimiento de pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            padding: 2rem 1rem;
        }

        .consultar-container {
            max-width: 550px;
            margin: 0 auto;
        }

        .card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-modern:hover {
            transform: translateY(-5px);
        }

        .card-header-modern {
            background: linear-gradient(135deg, #2c3e50 0%, #1a1a2e 100%);
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 3px solid #f39c12;
        }

        .card-header-modern h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .card-header-modern p {
            font-size: 0.9rem;
            opacity: 0.85;
            margin: 0;
        }

        .icon-header {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .form-control-modern {
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control-modern:focus {
            border-color: #f39c12;
            box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.1);
            outline: none;
            background: white;
        }

        .btn-modern {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            border-radius: 40px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(243, 156, 18, 0.3);
        }

        .result-card {
            background: #f8f9fa;
            border-radius: 24px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border-left: 4px solid #f39c12;
        }

        .badge-custom {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            background: #ecf0f1;
            color: #2c3e50;
        }

        .badge-success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .progress-modern {
            height: 12px;
            border-radius: 20px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar-modern {
            background: linear-gradient(90deg, #f39c12 0%, #e67e22 100%);
            border-radius: 20px;
            transition: width 0.5s ease;
        }

        .etapas-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .etapa-item {
            text-align: center;
            flex: 1;
            font-size: 11px;
            color: #7f8c8d;
            position: relative;
        }

        .etapa-item .dot {
            width: 10px;
            height: 10px;
            background: #bdc3c7;
            border-radius: 50%;
            margin: 0 auto 6px;
            transition: all 0.3s ease;
        }

        .etapa-item.completada .dot {
            background: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
        }

        .etapa-item.actual .dot {
            background: #f39c12;
            width: 14px;
            height: 14px;
            box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.3);
        }

        .etapa-item.completada .etapa-nombre,
        .etapa-item.actual .etapa-nombre {
            color: #2c3e50;
            font-weight: 600;
        }

        .etapa-nombre {
            font-size: 10px;
            font-weight: 500;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
            border: none;
            border-radius: 40px;
            padding: 12px 24px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(192, 57, 43, 0.3);
        }

        .alert-modern {
            border-radius: 20px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .footer-text i {
            margin-right: 4px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.4s ease-out;
        }
    </style>
</head>
<body>
    <div class="consultar-container">
        <div class="card-modern fade-in">
            <div class="card-header-modern text-white">
                <div class="icon-header">
                    <i class="fas fa-tools"></i>
                </div>
                <h2>Carpintería Ro-Ca</h2>
                <p>Sistema de seguimiento de pedidos</p>
            </div>

            <div class="p-4">
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

                <form method="GET" action="{{ route('client.consultar') }}">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-qrcode me-2"></i>Código del pedido
                        </label>
                        <input type="text" name="codigo" class="form-control form-control-modern"
                               placeholder="Ejemplo: 1, 2, 3..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-phone me-2"></i>Teléfono registrado
                        </label>
                        <input type="tel" name="telefono" class="form-control form-control-modern"
                               placeholder="El número que usaste al hacer tu pedido" required>
                    </div>
                    <button type="submit" class="btn btn-modern">
                        <i class="fas fa-search me-2"></i>Consultar mi pedido
                    </button>
                </form>

                @isset($order)
                    <div id="result-card" class="result-card" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @php
                                $stages = $order->productionStages->sortBy('stage_order');
                                $total = $stages->count();
                                $terminadas = $stages->where('state', 'terminado')->count();
                                $actual = $stages->firstWhere('state', 'en_proceso');
                                $porcentaje = $total > 0 ? round(($terminadas / $total) * 100) : 0;

                                $etiquetas = [
                                    'inicio' => 'Inicio',
                                    'corte' => 'Corte',
                                    'armado' => 'Armado',
                                    'lijado' => 'Lijado',
                                    'pintado' => 'Pintado',
                                    'listo_para_entregar' => 'Listo',
                                ];

                                $labelEstado = match ($order->status) {
                                    'active' => $etiquetas[$actual->stage ?? 'inicio'] ?? 'En proceso',
                                    'cancelled' => 'Cancelado',
                                    'finished' => 'Listo para entregar',
                                    default => 'En proceso',
                                };
                                $badgeClase = match ($order->status) {
                                    'cancelled' => 'badge-danger',
                                    'finished' => 'badge-success',
                                    default => 'badge-warning',
                                };
                            @endphp
                            <span class="badge-custom {{ $badgeClase }}">
                                <i class="fas fa-spinner me-1"></i>
                                {{ $labelEstado }}
                            </span>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $order->estimated_delivery?->format('d/m/Y') ?? $order->estimated_delivery }}
                            </small>
                        </div>

                        <h5 class="mb-2">{{ $order->client_name }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-box me-1"></i> {{ $order->product_description }}
                        </p>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span><i class="fas fa-chart-line me-1"></i>Progreso</span>
                                <span class="fw-bold">{{ round($porcentaje) }}%</span>
                            </div>
                            <div class="progress-modern">
                                <div class="progress-bar-modern" role="progressbar" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>

                        <div class="etapas-container mt-3">
                            @foreach($stages as $stage)
                                <div class="etapa-item {{ $stage->state === 'terminado' ? 'completada' : '' }} {{ $stage->state === 'en_proceso' ? 'actual' : '' }}">
                                    <div class="dot"></div>
                                    <div class="etapa-nombre">{{ $etiquetas[$stage->stage] ?? $stage->stage }}</div>
                                </div>
                            @endforeach
                        </div>

                        @if($order->canBeCancelled() && $order->status !== 'cancelled')
                            <div class="alert alert-warning alert-modern mt-3 mb-3">
                                <i class="fas fa-clock me-2"></i>
                                Puedes cancelar tu pedido dentro de las primeras 48 horas.
                            </div>
                            <form method="POST" action="{{ route('client.cancelar') }}"
                                  onsubmit="return confirm('¿Estás segura de que quieres cancelar este pedido? Se te reembolsará el anticipo.')">
                                @csrf
                                <input type="hidden" name="codigo" value="{{ $order->order_code }}">
                                <input type="hidden" name="telefono" value="{{ $order->client_phone }}">
                                <button type="submit" class="btn btn-cancel">
                                    <i class="fas fa-trash-alt me-2"></i>Cancelar pedido
                                </button>
                            </form>
                        @endif
                    </div>
                @endisset
            </div>
        </div>

        <div class="footer-text">
            <i class="fas fa-phone-alt"></i> 7341245678 |
            <i class="far fa-clock"></i> Lun-Vie 8:00 - 18:00
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resultCard = document.getElementById('result-card');
            if (resultCard) {
                resultCard.style.display = 'block';
                resultCard.classList.add('fade-in');
            }
        });
    </script>
</body>
</html>
