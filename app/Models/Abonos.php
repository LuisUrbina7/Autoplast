<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    use HasFactory;
    protected $table = 'abono_ventas';
    protected $fillable = [
        'fecha', 'monto', 'idFactura'
    ];
    
}
