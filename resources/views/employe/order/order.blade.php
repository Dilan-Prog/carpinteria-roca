<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Empleado - Roca</title>
</head>
<body>
    <h1>Mis Pedidos Asignados</h1>

    @if($pedidos->isEmpty())
        <p>No tienes ningún pedido asignado en este momento.</p>
    @else
        <table border="1">
            <tr>
                <th>Número Orden</th>
                <th>Descripción</th>
                <th>Estado Actual</th>
                <th>Fecha Entrega</th>
            </tr>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->numero_orden }}</td>
                <td>{{ $pedido->descripcion }}</td>
                <td>{{ $pedido->estado }}</td>
                <td>{{ $pedido->fecha_estimada_entrega }}</td>
            </tr>
            @endforeach
        </table>
    @endif
</body>
</html>