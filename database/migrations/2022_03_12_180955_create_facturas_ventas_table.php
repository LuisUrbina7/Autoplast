<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCliente')->constrained('clientes')->cascadeOnUpdate()->OnDelete('cascade'); 
            $table->date('Fecha');
            $table->char('Estado',10);
            $table->double('VendidoA', 12, 2);
            $table->double('PagadoA', 12, 2);     
            $table->double('VendidoB', 12, 2);
            $table->double('PagadoB', 12, 2);    
            $table->foreignId('idUsuario')->constrained('users')->cascadeOnUpdate()->OnDelete('cascade'); 
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
        Schema::dropIfExists('facturas_ventas');
    }
}
