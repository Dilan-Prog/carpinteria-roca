<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Bitácora de auditoría — SOLO INSERCIÓN (RNF-CONF-05).
     *
     * Esta tabla es inalterable por diseño:
     *  - Ningún usuario del sistema puede editar o eliminar sus registros.
     *  - No tiene updated_at porque un registro de auditoría nunca se modifica.
     *  - El modelo Eloquent correspondiente debe sobreescribir delete() y update()
     *    para lanzar una excepción si se intentan llamar.
     *
     * user_id es nullable para registrar eventos del cliente (que no tiene cuenta)
     * o eventos del sistema (jobs, schedulers).
     *
     * Acciones sugeridas a registrar:
     *  - order_created       → pedido registrado
     *  - order_updated       → datos del pedido modificados
     *  - order_cancelled     → pedido cancelado (admin o cliente)
     *  - stage_advanced      → etapa marcada como terminada y siguiente activada
     *  - unauthorized_access → intento de acceso con credenciales inválidas
     *  - client_access       → cliente consultó su pedido correctamente
     */
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();

            // Pedido relacionado (nullable para eventos globales del sistema)
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders')
                  ->nullOnDelete();

            // Usuario que realizó la acción (null = cliente sin cuenta o sistema)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Identificador corto de la acción realizada (ver lista arriba)
            $table->string('action', 60);

            // Descripción legible del evento para el panel de auditoría
            $table->text('description');

            // IP desde donde se realizó la acción
            $table->string('ip_address', 45)->nullable(); // 45 chars soporta IPv6

            // Solo created_at — nunca updated_at (registro inmutable)
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
