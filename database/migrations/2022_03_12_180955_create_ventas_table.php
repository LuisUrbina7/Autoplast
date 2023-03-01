<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCliente')->constrained('clientes')->cascadeOnUpdate()->OnDelete('cascade'); 
            $table->date('fecha');
            $table->char('estado',10);
            $table->double('vendido_A', 12, 2);
            $table->double('pagado_A', 12, 2);     
            $table->double('vendido_B', 12, 2);
            $table->double('pagado_B', 12, 2);    
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
        Schema::dropIfExists('ventas');
    }
}
