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
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-400 hover:bg-gray-50 rounded-xl transition-all font-semibold text-sm" title="Cerrar Sesión">
                <span class="material-symbols-outlined">logout</span>
                <span class="sidebar-text opacity-100 transition-opacity duration-200">Cerrar Sesión</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Mis Pedidos Asignados</h2>
            <p id="txt-contador-pedidos" class="text-sm text-gray-500 mt-1 font-medium">2 pedidos activos</p>
        </div>

        <div class="mb-8 max-w-md relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
            <input type="text" id="input-busqueda" placeholder="Buscar por código o descripción..." 
                   class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-gray-400">
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em]">
                        <th class="py-5 px-8">Número Orden</th>
                        <th class="py-5 px-8">Descripción del Producto</th>
                        <th class="py-5 px-8 text-center">Estado Actual</th>
                        <th class="py-5 px-8 text-center">Fecha Estimada</th>
                        <th class="py-5 px-8 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-pedidos" class="divide-y divide-gray-50 text-sm font-medium">
                    </tbody>
            </table>
        </div>
    </main>

    <div id="orderModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-[2px] flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] max-w-xl w-full p-8 shadow-2xl relative border border-gray-100">
            
            <button onclick="closeModal()" class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>

            <h3 class="text-2xl font-bold text-gray-800 mb-6">Detalle del Pedido</h3>

            <div class="grid grid-cols-2 gap-8 mb-6">
                <div>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Código de pedido</p>
                    <p id="modal-codigo" class="font-bold text-gray-800 text-base mt-1">-</p>
                </div>
                <div>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Fecha estimada de entrega</p>
                    <p id="modal-fecha" class="font-bold text-gray-700 text-base mt-1">-</p>
                </div>
            </div>

            <div class="mb-8">
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-2">Descripción del producto</p>
                <p id="modal-descripcion" class="text-gray-600 text-sm leading-relaxed mb-4">-</p>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-2">Estado actual</p>
                <span id="modal-badge-estado" class="inline-flex px-3 py-1 text-[11px] font-bold rounded-full border">-</span>
            </div>

            <div class="mb-10">
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-6">Progreso de Production</p>
                <div id="contenedor-linea-tiempo" class="flex items-center justify-between relative px-1">
                    <div class="absolute h-[2px] bg-gray-100 left-8 right-8 top-5 -z-10"></div>
                </div>
            </div>

            <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100">
                <h4 class="text-sm font-bold text-gray-800 mb-4">Actualizar estado</h4>
                <div id="info-etapas" class="space-y-3 mb-6"></div>
                <form id="form-actualizar-estado" action="" method="POST">
                @csrf
                @method('PATCH')
    
                    <button type="submit" id="btn-avanzar-etapa" class="w-full py-4 text-white font-bold rounded-xl transition-all shadow-lg active:scale-[0.98]">
                    Marcar etapa actual como Terminada
                    </button>
                </form>
                <p id="txt-nota-etapa" class="text-[10px] text-center text-gray-400 font-semibold mt-3"></p>
            </div>

            <div class="flex justify-end mt-6">
                <button onclick="closeModal()" class="text-gray-800 font-bold text-sm hover:underline">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        const ETAPAS = ["Compra de material", "Corte", "Armado", "Tapizado", "Acabado", "Entrega"];

        // 1. Inyectamos los $orders reales desde tu Controlador de Laravel
        let datosLaravel = @json($orders);

        // 2. Traducimos los nombres de tu base de datos al formato que usa tu JavaScript
        let pedidos = datosLaravel.map(order => ({
            id: order.id,                           // El ID numérico real para actualizar en la BD
            codigo: order.numero_orden,             // El string como "ORD-2026-001" para mostrar
            descripcion: order.descripcion,
            fecha: order.fecha_estimada_entrega,
            // Buscamos en qué número de etapa está basado en el texto de la base de datos
            etapaActual: ETAPAS.indexOf(order.estado) >= 0 ? ETAPAS.indexOf(order.estado) : 0,
            completadoTotal: order.estado === 'Entrega' // Cambia 'Entrega' si tu etapa final se llama distinto en la BD
        }));

        let pedidoSeleccionadoId = null;

        // --- SIDEBAR LÓGICA ---
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

        // --- SISTEMA DE PALETA DE 7 COLORES ---
        function obtenerEstadoGeneral(pedido) {
            if (pedido.completadoTotal) return { texto: "Completado", clases: "bg-emerald-50 text-emerald-600 border-emerald-200" };
            
            const etapasClases = [
                "bg-blue-50 text-blue-600 border-blue-200",       // 1. Compra (Azul)
                "bg-amber-50 text-amber-600 border-amber-200",     // 2. Corte (Ámbar)
                "bg-red-50 text-red-600 border-red-200",           // 3. Armado (Rojo)
                "bg-purple-50 text-purple-600 border-purple-200",   // 4. Tapizado (Morado)
                "bg-orange-50 text-orange-600 border-orange-200",   // 5. Acabado (Naranja)
                "bg-pink-50 text-pink-600 border-pink-200"          // 6. Entrega (Rosa / Magenta)
            ];
            return { texto: ETAPAS[pedido.etapaActual], clases: etapasClases[pedido.etapaActual] || "bg-gray-50 text-gray-600 border-gray-200" };
        }

        function renderizarTabla() {
            const tbody = document.getElementById('tabla-pedidos');
            tbody.innerHTML = '';
            pedidos.forEach(pedido => {
                const estado = obtenerEstadoGeneral(pedido);
                const tr = document.createElement('tr');
                tr.className = "hover:bg-gray-50/50 transition-colors group";
                tr.innerHTML = `
                    <td class="py-6 px-8 font-bold text-gray-900">${pedido.codigo}</td>
                    <td class="py-6 px-8 text-gray-500 max-w-xs truncate">${pedido.descripcion}</td>
                    <td class="py-6 px-8 text-center">
                        <span class="px-3 py-1 text-[11px] font-bold rounded-full border ${estado.clases}">${estado.texto}</span>
                    </td>
                    <td class="py-6 px-8 text-center text-gray-500">${pedido.fecha}</td>
                    <td class="py-6 px-8 text-center">
                        <button onclick="openModal('${pedido.codigo}')" class="text-gray-300 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            document.getElementById('txt-contador-pedidos').textContent = `${pedidos.length} pedidos activos`;
        }

        function renderizarModal(pedido) {
            document.getElementById('modal-codigo').textContent = pedido.codigo;
            document.getElementById('modal-fecha').textContent = pedido.fecha;
            document.getElementById('modal-descripcion').textContent = pedido.descripcion;
            
            const estadoG = obtenerEstadoGeneral(pedido);
            const badgeModal = document.getElementById('modal-badge-estado');
            badgeModal.className = `inline-flex px-3 py-1 text-[11px] font-bold rounded-full border ${estadoG.clases}`;
            badgeModal.textContent = pedido.completadoTotal ? "Completado" : ETAPAS[pedido.etapaActual];

            const contenedorLinea = document.getElementById('contenedor-linea-tiempo');
            contenedorLinea.innerHTML = '<div class="absolute h-[2px] bg-gray-100 left-8 right-8 top-5 -z-10"></div>';

            ETAPAS.forEach((nombreEtapa, index) => {
                const divNodo = document.createElement('div');
                divNodo.className = "flex flex-col items-center w-14";
                let htmlCirculo = '';
                let clasesTexto = 'text-gray-400';

                if (pedido.completadoTotal || index < pedido.etapaActual) {
                    htmlCirculo = `<div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-100"><span class="material-symbols-outlined text-xl">check</span></div>`;
                } else if (index === pedido.etapaActual && !pedido.completadoTotal) {
                    // Círculo activo estandarizado en Rojo para todas las etapas vigentes
                    htmlCirculo = `<div class="w-10 h-10 rounded-full bg-[#dc2626] ring-red-50 shadow-red-100 text-white flex items-center justify-center text-sm font-bold shadow-lg ring-4">${index + 1}</div>`;
                    clasesTexto = 'text-gray-800 font-bold';
                } else {
                    htmlCirculo = `<div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 border border-gray-200 flex items-center justify-center text-sm font-bold">${index + 1}</div>`;
                }
                divNodo.innerHTML = `${htmlCirculo}<span class="text-[9px] font-bold ${clasesTexto} mt-2 text-center leading-tight">${nombreEtapa.replace(' ', '<br>')}</span>`;
                contenedorLinea.appendChild(divNodo);
            });

            const infoEtapas = document.getElementById('info-etapas');
            const btnAvanzar = document.getElementById('btn-avanzar-etapa');
            const txtNota = document.getElementById('txt-nota-etapa');

            if (pedido.completadoTotal) {
                infoEtapas.innerHTML = `<div class="text-center text-sm font-bold text-emerald-600 py-2">¡El pedido ha sido entregado con éxito!</div>`;
                btnAvanzar.className = "w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-xl cursor-not-allowed text-center";
                btnAvanzar.textContent = "Proceso Finalizado";
                btnAvanzar.disabled = true;
                txtNota.style.display = 'none';
            } else {
                let esUltima = pedido.etapaActual === ETAPAS.length - 1;
                infoEtapas.innerHTML = `
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Etapa actual:</span>
                        <span class="font-bold text-gray-800">${ETAPAS[pedido.etapaActual]}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">${esUltima ? 'Estado:' : 'Siguiente etapa:'}</span>
                        <span class="font-bold ${esUltima ? 'text-emerald-600' : 'text-gray-400 italic'}">${esUltima ? 'Listo para archivar' : ETAPAS[pedido.etapaActual + 1]}</span>
                    </div>
                `;
                btnAvanzar.disabled = false;
                btnAvanzar.className = esUltima ? "w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-100 active:scale-[0.98]" : "w-full py-4 bg-[#dc2626] hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-100 active:scale-[0.98]";
                btnAvanzar.textContent = esUltima ? "Finalizar y Archivar Pedido" : "Marcar etapa actual como Terminada";
                txtNota.textContent = esUltima ? "Al confirmar, la orden pasará al estado Completado de forma permanente." : "Al completar esta etapa, la siguiente se activará automáticamente.";
                txtNota.style.display = 'block';
            }
        }

        function openModal(id) {
            pedidoSeleccionadoId = id;
            const pedido = pedidos.find(p => p.id === id);
            renderizarModal(pedido);
            document.getElementById('form-actualizar-estado').action = '/empleado/pedidos/' + pedido.id + '/estado';
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('orderModal').classList.add('hidden');
            pedidoSeleccionadoId = null;
        }

        function avanzarEtapaActual() {
            if (!pedidoSeleccionadoId) return;
            const pedido = pedidos.find(p => p.id === pedidoSeleccionadoId);
            if (!pedido) return;

            let mensajeConfirmacion = pedido.etapaActual === ETAPAS.length - 1 
                ? `¿Estás seguro de que deseas marcar el pedido ${pedido.id} como listo y entregado?\nEl estado cambiará permanentemente a "Completado".`
                : `¿Estás seguro de completar la etapa "${ETAPAS[pedido.etapaActual]}"?\nEl pedido cambiará automáticamente a "${ETAPAS[pedido.etapaActual + 1]}".`;

            if (!confirm(mensajeConfirmacion)) return;

            if (pedido.etapaActual === ETAPAS.length - 1) {
                pedido.completadoTotal = true;
            } else {
                pedido.etapaActual += 1;
            }

            renderizarTabla();
            closeModal();
        }

        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target == modal) closeModal();
        }

        // --- LÓGICA FILTRADO DEL BUSCADOR (FRONTEND) ---
        document.getElementById('input-busqueda').addEventListener('input', function(e) {
            const textoBusqueda = e.target.value.toLowerCase().trim();
            const tbody = document.getElementById('tabla-pedidos');
            const filas = tbody.getElementsByTagName('tr');
            let contadorActivos = 0;

            for (let i = 0; i < filas.length; i++) {
                const codigoOrden = filas[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                const descripcion = filas[i].getElementsByTagName('td')[1].textContent.toLowerCase();

                if (codigoOrden.includes(textoBusqueda) || descripcion.includes(textoBusqueda)) {
                    filas[i].style.display = "";
                    contadorActivos++;
                } else {
                    filas[i].style.display = "none";
                }
            }

            document.getElementById('txt-contador-pedidos').textContent = `${contadorActivos} pedido(s) encontrado(s)`;
        });

        document.addEventListener("DOMContentLoaded", () => renderizarTabla());
    </script>
</body>
</html>