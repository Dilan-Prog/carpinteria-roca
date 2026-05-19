<div id="modalEliminar" style="display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center;">
    
    <!-- Fondo oscuro -->
    <div onclick="cerrarModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.5);"></div>

    <!-- Contenido del modal -->
    <div style="position:relative; background:#fff; border-radius:12px; padding:32px; width:100%; max-width:400px; box-shadow:0 20px 60px rgba(0,0,0,0.2); text-align:center;">
        
        <!-- Ícono -->
        <div style="width:56px; height:56px; background:#fff0f1; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg width="28" height="28" fill="none" stroke="#e63946" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <!-- Título -->
        <h3 style="font-size:18px; font-weight:700; color:#1a1a1a; margin-bottom:8px;">
            ¿Eliminar pedido?
        </h3>

        <!-- Descripción -->
        <p style="font-size:14px; color:#888; margin-bottom:24px; line-height:1.5;">
            Esta acción no se puede deshacer. El pedido será eliminado permanentemente del sistema.
        </p>

        <!-- Botones -->
        <div style="display:flex; gap:12px; justify-content:center;">
            <button onclick="cerrarModal()" style="padding:10px 24px; border:1px solid #ddd; border-radius:8px; background:#fff; font-size:14px; font-weight:600; color:#555; cursor:pointer;">
                Cancelar
            </button>
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:10px 24px; border:none; border-radius:8px; background:#e63946; font-size:14px; font-weight:600; color:#fff; cursor:pointer;">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript-->
<script>
    function abrirModal(id) {
        document.getElementById('formEliminar').action = '/admin/orders/' + id;
        document.getElementById('modalEliminar').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modalEliminar').style.display = 'none';
    }
</script>