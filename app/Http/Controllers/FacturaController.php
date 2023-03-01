<?php

namespace App\Http\Controllers;

use App\Models\Abonos;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\Detalles;
use Exception;
use Illuminate\Http\Request;

class FacturaController extends Controller
{

    public function indexSalida()
    {
        $Clientes = Cliente::select('id', 'nombre', 'identificador')->get();
        $Factura = Factura::select('id')->latest('id')->first();
        $Numero = ['indice' => 1];

        /*  dd($Factura); */
        if ($Factura) {
            $Numero = ['indice' => $Factura->id + 1];
        }
        return view('Facturas.Salida', compact('Clientes', 'Numero'));
    }
    public function createSalida(Request $request)
    {

        $factura = [];
        $detalles = [];


        $Codigo = $request->input('Codigo');
        $Cantidad = $request->input('Cantidad');
        $Precio = $request->input('Precio');
        $Fecha = $request->input('Fecha');
        $idCliente = $request->input('idCliente');
        $Factura = $request->input('Factura');
        $Total = $request->input('Total');
        $IndividualTotal = $request->input('valor-total');
        $Moneda = $request->input('Moneda');
        $user = $request->input('idUsuario');
        $Unidad = $request->input('Unidad');
        $Estado  = '';

        if ($request->input('Estado') == 'Credito') {
            $Estado = 'Credito';
            $Abono = $request->input('valor-abono');
            if ($Abono == null) {
                $Abono = 0;
            }
        } else {
            $Estado = 'Cancelada';
            $Abono = $IndividualTotal;
        }

        try {

            if ($Moneda == 'COL') {
                $factura = [
                    'idCliente' => $idCliente,
                    'fecha' => $Fecha,
                    'estado' => $Estado,
                    'vendido_A' => str_replace(",", "", $IndividualTotal),
                    'pagado_A' => str_replace(",", "", $Abono),
                    'vendido_B' => 0,
                    'pagado_B' => 0,
                    'idUsuario' => $user,
                ];
            } else {

                $factura = [
                    'idCliente' => $idCliente,
                    'fecha' => $Fecha,
                    'estado' => $Estado,
                    'vendido_A' => 0,
                    'pagado_A' => 0,
                    'vendido_B' => str_replace(",", "", $IndividualTotal),
                    'pagado_B' => str_replace(",", "", $Abono),
                    'idUsuario' => $user,
                ];
            }

            Factura::create($factura);
        } catch (Exception $e) {
            return  response()->json([
                'Estado' => 1,
                'Mensaje' => 'Algo mal en la factura factura',
            ]);
        }

        try {
            $indice = Factura::select('id')->latest('id')->first()->toArray();
            for ($x = 0; $x < count($Codigo); $x++) {
                $detalles = [
                    'idfactura' => $indice['id'],
                    'idProducto' => $Codigo[$x],
                    'cantidad' => $Cantidad[$x],
                    'precio' => str_replace(",", "", $Precio[$x]),
                    'total' => str_replace(",", "", $Total[$x]),
                ];

                Detalles::create($detalles);
            };
        } catch (Exception $e) {
            return  response()->json([
                'Estado' => 1,
                'Mensaje' => $e,
            ]);
        }

        if ($request->input('valor-abono') != 0) {
            $this->agregarAbono($Fecha, $Abono, $Factura);
        }
        return  response()->json([
            'Estado' => 1,
            'Mensaje' => 'Todo bien',
        ]);
    }
    public function agregarAbono($date, $valor, $idFactura)
    {
        $Abonos = new Abonos;
        $Abonos->fecha = $date;
        $Abonos->monto = $valor;
        $Abonos->idFactura = $idFactura;
        $Abonos->save();
    }


    public function restar(Request $request, $id)
    {
        $update = Producto::where('id', $id)->first();
        $update->stock = $update->stock - $request->input('Cantidad');
        $update->update();
        return response()->json([
            'Estado' => 1,
            'Mensaje' => $update,
        ]);
    }

    /*     Esto no va */


    public function buscar($id)
    {
        $datos = Producto::select('detalles', 'stock', 'venta')->where('codigo', $id)->first();
        return response()->json(['title' => 'Hola', 'Mensaje' => $datos]);
    }

    public function devolver(Request $request)
    {
        $Codigo = $request->input('vCodigo');
        $Cantidad = $request->input('vCantidad');

        for ($x = 0; $x < count($Codigo); $x++) {
            $devolver = Producto::find($Codigo[$x]);
            $devolver->stock += $Cantidad[$x];
            $devolver->save();
        }


        return response()->json(['Estado' => 0, 'Mensaje' => 'Todo ben']);
    }
}
