<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    use HasFactory;
    protected $table = 'detalles';
    protected $fillable = [
        'idfactura','idProducto','Cantidad','Precio','Total',
    ];

    public function Facturas(){
        return $this->belongsTo(Factura::class,'idfactura');
    }

    public function Producto(){
        return $this->belongsTo(Producto::class,'idProducto');
    }   

}
