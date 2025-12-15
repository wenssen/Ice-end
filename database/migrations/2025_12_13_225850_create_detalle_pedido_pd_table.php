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
        Schema::create('detalle_pedido_pd', function (Blueprint $table) {
            $table->unsignedInteger('id_pedido_pd');
            $table->unsignedInteger('id_plan_produccion');
            $table->decimal('cantidad', 10, 2);

            $table->primary(['id_pedido_pd', 'id_plan_produccion']);

            $table->foreign('id_pedido_pd')
                ->references('id_pedido_pd')
                ->on('pedido_pd');

            $table->foreign('id_plan_produccion')
                ->references('id_plan_produccion')
                ->on('plan_produccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido_pd');
    }
};
