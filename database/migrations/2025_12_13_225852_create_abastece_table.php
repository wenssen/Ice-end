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
        Schema::create('abastece', function (Blueprint $table) {
            $table->unsignedInteger('id_proveedor');
            $table->unsignedInteger('id_materia_prima');
            $table->integer('plazo_entrega')->nullable();
            $table->decimal('precio_referencial', 10, 2)->nullable();

            $table->primary(['id_proveedor', 'id_materia_prima']);

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('proveedor');

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
        Schema::dropIfExists('abastece');
    }
};
