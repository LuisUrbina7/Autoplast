<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    use HasFactory;
    protected $table = 'detalles_ventas';
    protected $fillable = [
        'idfactura','idProducto','cantidad','precio','total',
    ];

    public function Facturas(){
        return $this->belongsTo(Factura::class,'idfactura');
    }

    public function Producto(){
        return $this->belongsTo(Producto::class,'idProducto');
    }   

}
