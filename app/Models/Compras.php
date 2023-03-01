<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;
    protected $table = 'compras';
    protected $fillable = [
        'idProveedor','fecha','estado','vendido_A','pagado_A','vendido_B','pagado_B','idUsuario'
    ];

    public function Proveedor(){
        return $this->belongsTo(Proveedor::class,'idProveedor');
    }
    public function DetallesCompras(){
        return $this->hasMany(Detalles_compras::class,'id');
    }
    public function Usuario(){
        return $this->belongsTo(User::class,'idUsuario');
    }
}
