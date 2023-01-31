<?php

namespace App\Imports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\ToModel;

class ProveedoresImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Proveedor([
            'Nombre'     => $row[0],
            'Direccion'     => $row[1],
            'Telefono'     => $row[2],
        ]);
    }
}
