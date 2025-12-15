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
        Schema::create('receta', function (Blueprint $table) {
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_materia_prima');
            $table->decimal('cantidad_requerida', 10, 2);

            $table->primary(['id_producto', 'id_materia_prima']);

            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('producto_terminado');

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
        Schema::dropIfExists('receta');
    }
};
