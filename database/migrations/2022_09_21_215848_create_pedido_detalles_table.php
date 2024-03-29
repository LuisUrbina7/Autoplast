<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPedido')->constrained('Pedidos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('detalles');
            $table->foreignId('idProducto')->nullable()->constrained('productos')->cascadeOnUpdate()->nullOnDelete();
            $table->float('cantidad', 5, 2);
            $table->double('precio', 12, 2);
            $table->double('total', 12, 2);
            $table->date('fecha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido_detalles');
    }
}
