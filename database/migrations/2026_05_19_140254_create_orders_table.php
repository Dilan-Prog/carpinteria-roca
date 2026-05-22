<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('users'); // Conecta el pedido con el empleado (User)
            $table->string('numero_orden'); // String para soportar letras y números como "ORD-2026-001"
            $table->string('descripcion');
            $table->string('estado'); // String para guardar la etapa actual: "Corte", "Armado", etc.
            $table->date('fecha_estimada_entrega');
            $table->timestamps();
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
