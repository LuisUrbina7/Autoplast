<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'facturas_ventas';
    protected $fillable = [
        'idCliente','Fecha','Estado','VendidoA','PagadoA','VendidoB','PagadoB','idUsuario'
    ];


    public function Cliente(){
        return $this->belongsTo(Cliente::class,'idCliente');
    }
    public function Detalles(){
        return $this->hasMany(Detalles::class,'id');
    }
    public function Usuario(){
        return $this->belongsTo(User::class,'idUsuario');
    }
}
