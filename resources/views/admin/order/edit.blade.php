<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
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

        .modal {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .btn-cerrar {
            background: none;
            border: none;
            font-size: 20px;
            color: #888;
            cursor: pointer;
        }

        .btn-cerrar:hover {
            color: #333;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .campo label span {
            color: #e63946;
        }

        .campo input,
        .campo textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            background-color: #fafafa;
            transition: border-color 0.2s;
            font-family: 'Segoe UI', sans-serif;
        }

        .campo input:focus,
        .campo textarea:focus {
            outline: none;
            border-color: #e63946;
            background-color: #fff;
        }

        .campo input:disabled {
            background-color: #f0f0f0;
            color: #666;
            cursor: not-allowed;
        }

        .campo textarea {
            resize: vertical;
            min-height: 90px;
        }

        .campo .input-prefix {
            position: relative;
        }

        .campo .input-prefix span {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 14px;
        }

        .campo .input-prefix input {
            padding-left: 26px;
        }

        .nota {
            font-size: 11px;
            color: #888;
            margin-top: 4px;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 28px;
        }

        .btn-cancelar {
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .btn-cancelar:hover {
            background-color: #f0f0f0;
        }

        .btn-guardar {
            background-color: #e63946;
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-guardar:hover {
            background-color: #c1121f;
        }

        .campo select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            color: #555;
            background-color: #fafafa;
            font-family: 'Segoe UI', sans-serif;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
        }

        .campo select:focus {
            outline: none;
            border-color: #e63946;
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="modal">

        <!-- Encabezado -->
        <div class="modal-header">
            <h2>Editar Pedido</h2>
            <button class="btn-cerrar">&times;</button>
        </div>

        <!-- Formulario -->
        <div class="campo">
            <label>Código del pedido</label>
            <input type="text" placeholder="Auto-generado por el sistema" disabled>
        </div>

        <div class="campo">
            <label>Nombre del cliente <span>*</span></label>
            <input type="text" placeholder="Nombre completo" required>
        </div>

        <div class="campo">
            <label>Número de teléfono <span>*</span></label>
            <input type="tel" placeholder="5551234567" required>
        </div>

        <div class="campo">
            <label>Descripción del producto <span>*</span></label>
            <textarea placeholder="Describe el producto en detalle..." required></textarea>
        </div>

        <div class="campo">
            <label>Costo total del pedido <span>*</span></label>
            <div class="input-prefix">
                <span>$</span>
                <input type="number" placeholder="0.00" min="0" step="0.01" required>
            </div>
        </div>

        <div class="campo">
            <label>Anticipo del pedido <span>*</span></label>
            <div class="input-prefix">
                <span>$</span>
                <input type="number" placeholder="0.00" min="0" step="0.01" required>
            </div>
            <p class="nota">El anticipo debe ser al menos el 50% del costo total</p>
        </div>

        <div class="campo">
            <label>Fecha estimada de entrega <span>*</span></label>
            <input type="date" required>
        </div>
        <div class="campo">
            <label>Estado del pedido <span>*</span></label>
            <select>
                <option value="" disabled selected>Selecciona una etapa</option>
                <option value="inicio">Inicio</option>
                <option value="corte">Corte</option>
                <option value="armado">Armado</option>
                <option value="lijado">Lijado</option>
                <option value="pintado">Pintado</option>
                <option value="listo">Listo para entregar</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="modal-footer">
            <a href="/admin/orders" style="text-decoration: none;">
                <button class="btn-cancelar">Cancelar</button>
            </a>
            <button class="btn-guardar">Guardar cambios</button>
        </div>

    </div>

</body>

</html>