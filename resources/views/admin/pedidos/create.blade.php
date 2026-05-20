@extends('layouts.admin')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3>Nuevo Pedido</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre del cliente *</label>
                <input type="text" name="nombre_cliente" class="form-control @error('nombre_cliente') is-invalid @enderror" value="{{ old('nombre_cliente') }}" required>
                @error('nombre_cliente') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono *</label>
                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción del producto *</label>
                <textarea name="descripcion_producto" class="form-control @error('descripcion_producto') is-invalid @enderror" rows="3" required>{{ old('descripcion_producto') }}</textarea>
                @error('descripcion_producto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Costo total *</label>
                    <input type="number" step="0.01" name="costo_total" class="form-control @error('costo_total') is-invalid @enderror" value="{{ old('costo_total') }}" required>
                    @error('costo_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Anticipo * (mínimo 50%)</label>
                    <input type="number" step="0.01" name="anticipo" class="form-control @error('anticipo') is-invalid @enderror" value="{{ old('anticipo') }}" required>
                    @error('anticipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">El anticipo debe ser al menos el 50% del costo total</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha estimada de entrega *</label>
                <input type="date" name="fecha_estimada_entrega" class="form-control @error('fecha_estimada_entrega') is-invalid @enderror" value="{{ old('fecha_estimada_entrega') }}" required>
                @error('fecha_estimada_entrega') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Guardar Pedido</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection