<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->char('detalles',150);
            $table->float('stock', 5, 2);
            $table->double('costo', 12, 2);
            $table->double('venta', 12, 2);
            $table->char('unidad',20);
            $table->date('fecha');
            $table->integer('ruta');
            $table->foreignId('idProveedor')->nullable()->constrained('proveedores')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('idCategoria')->nullable()->constrained('categorias')->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('productos');
    }
}
