<?php

namespace App\Http\Controllers;

use App\Models\AbonoCompra;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Compras;
use App\Models\Detalles_compras;

class ComprasController extends Controller
{
    public function indexEntrada()
    {
        $proveedores = Proveedor::select('id', 'Nombre')->get();
        $compra = Compras::select('id')->latest('id')->first();
        $Numero = ['indice' => 1];

        /*  dd($Factura); */
        if ($compra) {
            $Numero = ['indice' => $compra->id + 1];
        }
        return view('Facturas.Entrada', compact('proveedores', 'Numero'));
    }
    public function createEntrada(Request $request)
    {
        $compra = [];
        $detalles = [];

        $Codigo = $request->input('Codigo');
        $Cantidad = $request->input('Cantidad');
        $Precio = $request->input('Precio');
        $Fecha = $request->input('Fecha');
        $idProveedor = $request->input('idProveedor');
        $Factura = $request->input('Factura');
        $Total = $request->input('Total');
        $IndividualTotal = $request->input('valor-total');
        $Moneda = $request->input('Moneda');
        $user = $request->input('idUsuario');

        if ($request->input('Estado') == 'Credito') {
            $Estado = 'Credito';
            $Abono = $request->input('valor-abono');
        } else {
            $Estado = 'Cancelada';
            $Abono = $IndividualTotal;
        }
        if ($Moneda == 'COL') {
            $compra = [
                'idProveedor' => $idProveedor,
                'Fecha' => $Fecha,
                'Estado' => $Estado,
                'VendidoA' => str_replace(",", "", $IndividualTotal),
                'PagadoA' => str_replace(",", "", $Abono),
                'VendidoB' => 0,
                'PagadoB' => 0,
                'idUsuario' => $user,
            ];
        } else {
            $compra = [
                'idProveedor' => $idProveedor,
                'Fecha' => $Fecha,
                'Estado' => $Estado,
                'VendidoA' => 0,
                'PagadoA' => 0,
                'VendidoB' => str_replace(",", "", $IndividualTotal),
                'PagadoB' => str_replace(",", "", $Abono),
                'idUsuario' => $user,
            ];
        }


        Compras::create($compra);

        for ($x = 0; $x < count($Codigo); $x++) {
            $detalles = [
                'idfactura' => $Factura,
                'idProducto' => $Codigo[$x],
                'Cantidad' => $Cantidad[$x],
                'Precio' => str_replace(",", "", $Precio[$x]),
                'Total' => str_replace(",", "", $Total[$x]),
            ];

            Detalles_compras::create($detalles);
        };
        if ($request->input('valor-abono') != 0) {
            $this->agregarAbono($Fecha, $Abono, $Factura);
        }

        return  response()->json([
            'Estado' => 1,
            'Mensaje' => $compra,
        ]);
    }

    public function agregarAbono($date, $valor, $idFactura)
    {
        $Abonos = new AbonoCompra;
        $Abonos->Fecha = $date;
        $Abonos->Monto = $valor;
        $Abonos->idFactura = $idFactura;
        $Abonos->save();
    }
    public function sumar(Request $request, $id)
    {
        $update = Producto::where('id', $id)->first();
        $update->Stock = $update->Stock + $request->input('Cantidad');
        $update->update();
        return response()->json([
            'Estado' => 1,
            'Mensaje' => $update,
        ]);
    }
    public function devolver(Request $request)
    {
        $Codigo = $request->input('vCodigo');
        $Cantidad = $request->input('vCantidad');

        for ($x = 0; $x < count($Codigo); $x++) {
            $devolver = Producto::find($Codigo[$x]);
            $devolver->Stock -= $Cantidad[$x];
            $devolver->save();
        }

        return response()->json(['Estado' => 0, 'Mensaje' => $request->all()]);
    }
}
