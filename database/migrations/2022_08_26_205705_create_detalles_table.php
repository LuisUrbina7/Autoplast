<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
 
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idfactura')->constrained('facturas_ventas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('idProducto')->nullable()->constrained('productos')->cascadeOnUpdate()->nullOnDelete();
            $table->float('Cantidad', 5, 2);
            $table->double('Precio', 12, 2);
            $table->double('Total', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
