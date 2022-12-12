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
            $table->char('Detalles',150)->unique();
            $table->float('Stock', 5, 2);
            $table->double('PrecioCompra', 12, 2);
            $table->double('PrecioVenta', 12, 2);
            $table->char('Unidad',20);
            $table->date('Fecha');
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
