<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable = [
        'idCliente','fecha','estado','vendido_A','pagado_A','vendido_B','pagado_B','idUsuario'
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
