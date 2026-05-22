<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabla principal del sistema. Almacena todos los pedidos registrados.
     *
     * Notas de diseño:
     *  - El cliente NO tiene cuenta en el sistema. Se identifica únicamente
     *    con order_code + client_phone (validado en el portal del cliente).
     *  - La regla del 50% de anticipo se valida en la capa de negocio (Laravel),
     *    no aquí como constraint de BD.
     *  - La regla de cancelación (48 horas) se valida comparando created_at
     *    con Carbon::now() en el backend.
     *  - remaining_balance se guarda para facilitar consultas y auditoría,
     *    aunque se puede derivar de (total_cost - advance_payment).
     *  - assigned_to puede ser null si aún no se asigna un empleado al pedido.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Identificador único visible al cliente (ej. "PED-000001")
            // Se genera en el OrderService antes de insertar, no en la BD.
            $table->string('order_code', 20)->unique();

            // Usuario administrador que registró el pedido
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Empleado asignado a ejecutar el pedido (puede asignarse después)
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Datos del cliente (sin cuenta en el sistema)
            $table->string('client_name', 150);
            $table->string('client_phone', 20);   // Clave de acceso del cliente junto a order_code

            // Descripción del producto a fabricar
            $table->text('product_description');

            // Datos económicos
            $table->decimal('total_cost', 10, 2);
            $table->decimal('advance_payment', 10, 2);        // Mínimo 50% de total_cost
            $table->decimal('remaining_balance', 10, 2);      // total_cost - advance_payment

            // Fecha estimada de entrega pactada con el cliente
            $table->date('estimated_delivery');

            // Estado general del pedido
            // 'active'    → en alguna etapa de producción
            // 'cancelled' → cancelado dentro de las primeras 48 horas
            // 'finished'  → todas las etapas completadas (listo para entregar)
            $table->enum('status', ['active', 'cancelled', 'finished'])->default('active');

            // Se registra cuándo se canceló para auditoría
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps(); // created_at se usa para la regla de las 48 horas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
