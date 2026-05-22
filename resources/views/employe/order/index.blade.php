<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpintería Roca - Empleado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .transition-sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-[#f8fafc] font-sans antialiased flex h-screen overflow-hidden text-gray-800">

    <aside id="sidebar" class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between p-6 relative transition-sidebar z-20">
        <button onclick="toggleSidebar()" title="Contraer / Expandir"
                class="absolute -right-3 top-7 bg-white border border-gray-100 text-gray-400 hover:text-red-500 w-6 h-6 rounded-full flex items-center justify-center shadow-sm cursor-pointer transition-transform hover:scale-110">
            <span id="btn-sidebar-icon" class="material-symbols-outlined text-sm font-bold">chevron_left</span>
        </button>

        <div>
            <div id="sidebar-logo-container" class="mb-10 text-center transition-all duration-200">
                <h1 id="logo-text" class="text-3xl font-bold text-[#dc2626]">Roca</h1>
                <p id="logo-subtext" class="text-[10px] text-gray-400 font-bold tracking-widest uppercase mt-1">Sistema de Gestión</p>
            </div>

            <p id="sidebar-tag" class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Panel Empleado</p>

            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl transition-all" title="Mis Pedidos">
                    <span class="material-symbols-outlined text-red-500">box</span>
                    <span class="sidebar-text opacity-100 transition-opacity duration-200">Mis Pedidos</span>
                </a>
            </nav>
        </div>

        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-gray-400 hover:bg-gray-50 rounded-xl transition-all font-semibold text-sm" title="Cerrar Sesión">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="sidebar-text opacity-100 transition-opacity duration-200">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto p-10">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Pedidos del Sistema</h2>
            <p id="txt-contador-pedidos" class="text-sm text-gray-500 mt-1 font-medium">{{ $orders->count() }} pedidos en total</p>
        </div>

        <div class="mb-8 max-w-md relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
            <input type="text" id="input-busqueda" placeholder="Buscar por código o descripción..."
                   class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-gray-400">
        </div>

        @php
            $stageLabels = [
                'inicio' => 'Inicio',
                'corte' => 'Corte',
                'armado' => 'Armado',
                'lijado' => 'Lijado',
                'pintado' => 'Pintado',
                'listo_para_entregar' => 'Listo para entregar',
            ];
            $statusClasses = [
                'active' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                'cancelled' => 'bg-red-50 text-red-600 border-red-200',
                'finished' => 'bg-gray-100 text-gray-500 border-gray-200',
            ];
            $statusLabels = [
                'active' => 'Activo',
                'cancelled' => 'Cancelado',
                'finished' => 'Finalizado',
            ];
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em]">
                        <th class="py-5 px-8">Código</th>
                        <th class="py-5 px-8">Cliente</th>
                        <th class="py-5 px-8">Descripción</th>
                        <th class="py-5 px-8 text-center">Etapa actual</th>
                        <th class="py-5 px-8 text-center">Estado</th>
                        <th class="py-5 px-8 text-center">Entrega estimada</th>
                        <th class="py-5 px-8 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-pedidos" class="divide-y divide-gray-50 text-sm font-medium">
                    @forelse ($orders as $order)
                        @php
                            $activeStage = $order->productionStages->firstWhere('state', 'en_proceso');
                            $activeStageLabel = $activeStage ? ($stageLabels[$activeStage->stage] ?? 'En proceso') : 'Sin etapa';
                            $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';
                            $statusLabel = $statusLabels[$order->status] ?? 'Finalizado';
                            $stagesOrdered = $order->productionStages->sortBy('stage_order');
                        @endphp
                        <tr data-row="order" class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-6 px-8 font-bold text-gray-900" data-col="code">{{ $order->order_code }}</td>
                            <td class="py-6 px-8 text-gray-700" data-col="client">{{ $order->client_name }}</td>
                            <td class="py-6 px-8 text-gray-500 max-w-xs" data-col="desc">
                                <div class="truncate">{{ $order->product_description }}</div>
                                <div class="mt-3 flex items-center gap-2">
                                    @foreach ($stagesOrdered as $stage)
                                        @php
                                            $progressClass = $stage->state === 'terminado'
                                                ? 'bg-emerald-500'
                                                : ($stage->state === 'en_proceso' ? 'bg-red-500 ring-2 ring-red-100' : 'bg-gray-200');
                                        @endphp
                                        <span class="h-2.5 w-2.5 rounded-full {{ $progressClass }}" title="{{ $stageLabels[$stage->stage] ?? $stage->stage }}"></span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-6 px-8 text-center">
                                <span class="inline-flex px-3 py-1 text-[11px] font-bold rounded-full border bg-gray-50 text-gray-600 border-gray-200">
                                    {{ $activeStageLabel }}
                                </span>
                            </td>
                            <td class="py-6 px-8 text-center">
                                <span class="inline-flex px-3 py-1 text-[11px] font-bold rounded-full border {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="py-6 px-8 text-center text-gray-500">
                                {{ $order->estimated_delivery?->format('d/m/Y') ?? $order->estimated_delivery }}
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if ($order->status === 'active' && $activeStage)
                                    <form method="POST" action="{{ route('employee.empleado.pedidos.updateStatus', $activeStage->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition-all">
                                            Avanzar etapa
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 font-semibold">Sin acciones</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-sm text-gray-400">No hay pedidos asignados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('btn-sidebar-icon');
            const logoText = document.getElementById('logo-text');
            const logoSubtext = document.getElementById('logo-subtext');
            const sidebarTag = document.getElementById('sidebar-tag');
            const textElements = document.querySelectorAll('.sidebar-text');

            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64', 'p-6');
                sidebar.classList.add('w-20', 'px-3', 'py-6');
                icon.textContent = 'chevron_right';
                logoText.textContent = 'R';
                logoSubtext.classList.add('hidden');
                sidebarTag.classList.add('hidden');
                textElements.forEach(el => {
                    el.classList.add('hidden');
                    el.classList.remove('opacity-100');
                });
            } else {
                sidebar.classList.remove('w-20', 'px-3', 'py-6');
                sidebar.classList.add('w-64', 'p-6');
                icon.textContent = 'chevron_left';
                logoText.textContent = 'Roca';
                logoSubtext.classList.remove('hidden');
                sidebarTag.classList.remove('hidden');
                textElements.forEach(el => {
                    el.classList.remove('hidden');
                    setTimeout(() => el.classList.add('opacity-100'), 50);
                });
            }
        }

        const inputBusqueda = document.getElementById('input-busqueda');
        if (inputBusqueda) {
            inputBusqueda.addEventListener('input', function (e) {
                const textoBusqueda = e.target.value.toLowerCase().trim();
                const filas = document.querySelectorAll('#tabla-pedidos tr[data-row="order"]');
                let contadorActivos = 0;

                filas.forEach((fila) => {
                    const codigoOrden = fila.querySelector('[data-col="code"]')?.textContent.toLowerCase() || '';
                    const descripcion = fila.querySelector('[data-col="desc"]')?.textContent.toLowerCase() || '';

                    if (codigoOrden.includes(textoBusqueda) || descripcion.includes(textoBusqueda)) {
                        fila.style.display = '';
                        contadorActivos++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                const contador = document.getElementById('txt-contador-pedidos');
                if (contador) {
                    contador.textContent = `${contadorActivos} pedido(s) encontrado(s)`;
                }
            });
        }
    </script>
</body>
</html>
