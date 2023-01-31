<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cliente([
            'Nombre'     => $row[0],
            'Apellido'     => $row[1],
            'Identificador'     => $row[2],
            'Zona'     => $row[3],
            'Direccion'     => $row[4],
            'Telefono'     => $row[5],
        ]);
    }
}
