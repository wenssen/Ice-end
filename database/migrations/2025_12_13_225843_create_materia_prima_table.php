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
        if (!Schema::hasTable('materia_prima')) {
            Schema::create('materia_prima', function (Blueprint $table) {
                $table->increments('id_materia_prima');
                $table->string('nombre', 100);
                $table->string('unidad_medida', 50);
                $table->decimal('stock_actual', 10, 2)->default(0);
                $table->decimal('stock_minimo', 10, 2)->default(0);
                $table->decimal('costo_unitario', 10, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia_prima');
    }
};
