<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = [
        'nombre', 'qpellido','identificador','zona','direccion','telefono',
    ];

    public function Facturas(){
        return $this->hasMany(Factura::class,'id');
    }
}
