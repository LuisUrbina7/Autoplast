<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = [
        'Cliente','Fecha','Estado','idUsuario'
    ];
    public function DetallesPedidos(){
        return $this->hasMany(PedidoDetalle::class,'id');
    }

}
