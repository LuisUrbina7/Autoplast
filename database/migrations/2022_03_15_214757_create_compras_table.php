<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
  
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProveedor')->nullable()->constrained('proveedores')->cascadeOnUpdate()->nullOnDelete();
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

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
