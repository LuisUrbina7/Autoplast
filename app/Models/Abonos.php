<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    use HasFactory;
    protected $table = 'abonos';
    protected $fillable = [
        'Fecha', 'Monto', 'idFactura'
    ];
    
}
