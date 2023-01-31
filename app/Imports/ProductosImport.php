<?php

namespace App\Imports;

use App\Models\Producto;
use GuzzleHttp\Promise\Create;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductosImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Producto([
            'Detalles'     => $row[0],
            'Stock'     => $row[1],
            'PrecioCompra'     => $row[2],
            'PrecioVenta'     => $row[3],
            'Unidad'     => $row[4],
            'Fecha'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
            'idProveedor' => $row[6],
            'idCategoria' => $row[7],
        ]);
    }
}
