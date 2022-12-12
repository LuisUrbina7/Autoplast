<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles_compras extends Model
{
    use HasFactory;
    protected $table = 'detalles_compras';
    protected $fillable = [
        'idfactura','idProducto','Cantidad','Precio','Total',
    ];

   public function Compras(){
        return $this->belongsTo(Compras::class,'idfactura');
    }

    public function Producto(){
        return $this->belongsTo(Producto::class,'idProducto');
    }   
}
