<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabla de etapas de producción.
     *
     * Diseño de secuencia:
     *  Cada pedido tiene exactamente 6 filas en esta tabla (una por etapa),
     *  creadas automáticamente al registrar el pedido con estado 'pendiente'.
     *  La primera etapa (inicio) se pone en 'en_proceso' al crear el pedido.
     *
     *  Secuencia obligatoria (no se puede saltar):
     *    inicio → corte → armado → lijado → pintado → listo_para_entregar
     *
     *  Orden se determina por la columna `stage_order` (1 al 6).
     *
     * Regla de negocio crítica (validar en OrderService):
     *  - No se puede pasar una etapa a 'terminado' si la anterior no está 'terminado'.
     *  - No se puede modificar el estado de pedidos con status 'cancelled' o 'finished'.
     *  - El administrador NO puede modificar etapas después de 'armado' terminado
     *    (para los datos del pedido, no para el estado de etapa).
     */
    public function up(): void
    {
        Schema::create('production_stages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            // Nombre de la etapa (valor fijo del proceso de producción)
            $table->enum('stage', [
                'inicio',
                'corte',
                'armado',
                'lijado',
                'pintado',
                'listo_para_entregar',
            ]);

            // Posición en la secuencia (1=inicio, 6=listo_para_entregar)
            // Facilita validar que no se salten etapas sin depender del orden del enum.
            $table->unsignedTinyInteger('stage_order');

            // Estado actual de esta etapa
            $table->enum('state', [
                'pendiente',    // Aún no es su turno
                'en_proceso',   // La etapa está activa actualmente
                'terminado',    // Etapa completada
            ])->default('pendiente');

            // Auditoría de tiempos por etapa
            $table->timestamp('started_at')->nullable();   // Cuando pasó a 'en_proceso'
            $table->timestamp('finished_at')->nullable();  // Cuando pasó a 'terminado'

            // Un pedido no puede tener dos filas de la misma etapa
            $table->unique(['order_id', 'stage']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_stages');
    }
};
