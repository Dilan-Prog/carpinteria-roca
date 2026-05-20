<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('telefono', 20);
            $table->text('descripcion_producto');
            $table->decimal('costo_total', 10, 2);
            $table->decimal('anticipo', 10, 2);
            $table->date('fecha_estimada_entrega');
            $table->enum('estado', [
                'inicio', 'corte', 'armado', 'lijado', 
                'pintado', 'listo_para_entregar', 'cancelado'
            ])->default('inicio');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};