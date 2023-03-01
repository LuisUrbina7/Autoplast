<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    use HasFactory;
    protected $table = 'pedido_detalles';
    protected $fillable = [
        'idPedido','detalles','idProducto','cantidad','precio','total','fecha'
    ];
    public function Pedidos(){
        return $this->belongsTo(Pedido::class,'idPedido');
    }

}
