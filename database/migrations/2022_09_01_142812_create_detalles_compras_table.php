<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idFactura')->constrained('compras')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('idProducto')->nullable()->constrained('productos')->cascadeOnUpdate()->nullOnDelete();
            $table->float('cantidad', 5, 2);
            $table->double('precio', 12, 2);
            $table->double('total', 12, 2);
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
        Schema::dropIfExists('detalles_compras');
    }
}
