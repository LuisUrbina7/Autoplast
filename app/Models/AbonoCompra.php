<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonoCompra extends Model
{
    use HasFactory;
    protected $table = 'abono_compras';
    protected $fillable = [
        'Fecha', 'Monto', 'idFactura'
    ];
}
