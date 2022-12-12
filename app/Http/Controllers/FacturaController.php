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
        $Clientes = Cliente::select('id', 'Nombre')->get();
        $NumeroFactura = Factura::select('id')->orderBy('id', 'desc')->first();
        $Numero = $NumeroFactura['id'];
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
        } else {
            $Estado = 'Cancelada';
            $Abono = $IndividualTotal;
        }
        try {
            try {

                if ($Moneda == 'COL') {
                    $factura = [
                        'idCliente' => $idCliente,
                        'Fecha' => $Fecha,
                        'Estado' => $Estado,
                        'VendidoA' => str_replace(",", "", $IndividualTotal),
                        'PagadoA' => str_replace(",", "", $Abono),
                        'VendidoB' => 0,
                        'PagadoB' => 0,
                        'idUsuario' => $user,
                    ];
                } else {

                    $factura = [
                        'idCliente' => $idCliente,
                        'Fecha' => $Fecha,
                        'Estado' => $Estado,
                        'VendidoA' => 0,
                        'PagadoA' => 0,
                        'VendidoB' => str_replace(",", "", $IndividualTotal),
                        'PagadoB' => str_replace(",", "", $Abono),
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
                for ($x = 0; $x < count($Codigo); $x++) {
                    $detalles = [
                        'idfactura' => $Factura,
                        'idProducto' => $Codigo[$x],
                        'Cantidad' => $Cantidad[$x],
                        'Precio' => str_replace(",", "", $Precio[$x]),
                        'Total' => str_replace(",", "", $Total[$x]),

                    ];
                    Detalles::create($detalles);
                };
            } catch (Exception $e) {
                return  response()->json([
                    'Estado' => 1,
                    'Mensaje' => 'Algo mal en los detalles',
                ]);
            }

            if ($request->input('valor-abono') != 0) {
                $this->agregarAbono($Fecha, $Abono, $Factura);
            }
            return  response()->json([
                'Estado' => 1,
                'Mensaje' => 'Todo ben',
            ]);
        } catch (Exception $e) {
            return  response()->json([
                'Estado' => 1,
                'Mensaje' => 'Todo mal',
            ]);
        }
    }
    public function agregarAbono($date, $valor, $idFactura)
    {
        $Abonos = new Abonos;
        $Abonos->Fecha = $date;
        $Abonos->Monto = $valor;
        $Abonos->idFactura = $idFactura;
        $Abonos->save();
    }

   
    public function restar(Request $request, $id)
    {
        $update = Producto::where('id', $id)->first();
        $update->Stock = $update->Stock - $request->input('Cantidad');
        $update->update();
        return response()->json([
            'Estado' => 1,
            'Mensaje' => $update,
        ]);
    }

    /*     Esto no va */


    public function buscar($id)
    {
        $datos = Producto::select('Detalles', 'Stock', 'PrecioVenta')->where('Codigo', $id)->first();
        return response()->json(['title' => 'Hola', 'Mensaje' => $datos]);
    }

    public function devolver(Request $request){
            $Codigo =$request->input('vCodigo');
            $Cantidad =$request->input('vCantidad');
       
             for($x=0;$x<count($Codigo);$x++){
             $devolver = Producto::find($Codigo[$x]);
             $devolver->Stock +=$Cantidad[$x]; 
             $devolver->save();
           }
             
      
             return response()->json(['Estado'=>0,'Mensaje'=>'Todo ben']);
            
       
    }
}
