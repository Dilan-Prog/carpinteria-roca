<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'nombre_cliente',
        'telefono',
        'descripcion_producto',
        'costo_total',
        'anticipo',
        'fecha_estimada_entrega',
        'estado'
    ];

    // Regla de negocio: anticipo >= 50% del costo total
    public function validarAnticipo(): bool
    {
        return $this->anticipo >= ($this->costo_total * 0.5);
    }

    // Verificar si se puede editar (no después de "armado")
    public function puedeEditarse(): bool
    {
        $estadosNoEditables = ['armado', 'lijado', 'pintado', 'listo_para_entregar'];
        return !in_array($this->estado, $estadosNoEditables);
    }

    // Verificar si se puede cancelar (dentro de 48 horas)
    public function puedeCancelarse(): bool
    {
        return $this->created_at->diffInHours(now()) <= 48;
    }
}