<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = [
        'Codigo','Detalles','Stock','Unidad','PrecioCompra','PrecioVenta','Fecha','idProveedor','idCategoria',
    ];

    public function Proveedor(){
        return $this->belongsTo(Proveedor::class,'idProveedor');
    }

    public function Categoria(){
        return $this->belongsTo(Categoria::class,'idCategoria');
    }
    
    public function Detalles(){
        return $this->hasMany(Detalles::class,'id');
    }


}
