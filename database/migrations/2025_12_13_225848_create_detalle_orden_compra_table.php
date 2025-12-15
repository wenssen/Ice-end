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
        Schema::create('detalle_orden_compra', function (Blueprint $table) {
            $table->increments('id_detalle_oc');
            $table->unsignedInteger('id_orden_compra');
            $table->unsignedInteger('id_materia_prima');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);

            $table->foreign('id_orden_compra')
                ->references('id_orden_compra')
                ->on('orden_compra');

            $table->foreign('id_materia_prima')
                ->references('id_materia_prima')
                ->on('materia_prima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_orden_compra');
    }
};
