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

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
