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
        Schema::create('plan_produccion', function (Blueprint $table) {
            $table->increments('id_plan_produccion');
            $table->date('fecha_plan');
            $table->date('fecha_ejecucion')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'finalizado'])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_produccion');
    }
};
