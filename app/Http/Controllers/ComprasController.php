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
        $proveedores = Proveedor::select('id', 'nombre')->get();
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
            if($Abono == null){
                $Abono=0;
            }
        } else {
            $Estado = 'Cancelada';
            $Abono = $IndividualTotal;
        }

        if ($Moneda == 'COL') {
            $compra = [
                'idProveedor' => $idProveedor,
                'fecha' => $Fecha,
                'estado' => $Estado,
                'vendido_A' => str_replace(",", "", $IndividualTotal),
                'pagado_A' => str_replace(",", "", $Abono),
                'vendido_B' => 0,
                'pagado_B' => 0,
                'idUsuario' => $user,
            ];
        } else {
            $compra = [
                'idProveedor' => $idProveedor,
                'fecha' => $Fecha,
                'estado' => $Estado,
                'vendido_A' => 0,
                'pagado_A' => 0,
                'vendido_B' => str_replace(",", "", $IndividualTotal),
                'pagado_B' => str_replace(",", "", $Abono),
                'idUsuario' => $user,
            ];
        }

        Compras::create($compra);
        $indice = Compras::select('id')->latest('id')->first()->toArray();
        for ($x = 0; $x < count($Codigo); $x++) {
            $detalles = [
                'idfactura' => $indice['id'],
                'idProducto' => $Codigo[$x],
                'cantidad' => $Cantidad[$x],
                'precio' => str_replace(",", "", $Precio[$x]),
                'total' => str_replace(",", "", $Total[$x]),
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
        $Abonos->fecha = $date;
        $Abonos->monto = $valor;
        $Abonos->idFactura = $idFactura;
        $Abonos->save();
    }
    public function sumar(Request $request, $id)
    {
        $update = Producto::where('id', $id)->first();
        $update->stock = $update->stock + $request->input('Cantidad');
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
            $devolver->stock -= $Cantidad[$x];
            $devolver->save();
        }

        return response()->json(['Estado' => 0, 'Mensaje' => $request->all()]);
    }
}
