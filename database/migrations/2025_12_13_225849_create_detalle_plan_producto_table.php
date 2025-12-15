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
        Schema::create('detalle_plan_producto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('id_plan_produccion');
            $table->unsignedInteger('id_producto');
            $table->decimal('cantidad_a_producir', 10, 2);

            $table->primary(['id_plan_produccion', 'id_producto']);

            $table->foreign('id_plan_produccion')
                ->references('id_plan_produccion')
                ->on('plan_produccion');

            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('producto_terminado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_plan_producto');
    }
};
