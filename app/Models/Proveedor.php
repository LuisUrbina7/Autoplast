<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $fillable = [
        'Nombre','Direccion','Telefono',
    ];

       public function Productos(){
        return $this->hasMany(Producto::class,'id');
    }
    public function Compras(){
        return $this->hasMany(Compras::class,'id');
    }
}
