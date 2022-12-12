<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Detalles;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index()
    {
        $Pedidos = Pedido::all();
        $Pref = Pedido::select('id')->orderBy('id', 'desc')->first();
        $Numero = $Pref['id'];
        
        /*  dd($Numero); */
        return view('Pedidos.Principal', compact('Pedidos', 'Numero'));
    }
    public function agregar(Request $request)
    {

        /*    dd($request->all()); */

        $pedido = [];
        $detalle = [];
        $Cliente = $request->input('Cliente');
        $Fecha = $request->date('Fecha');
        $Detalles = $request->input('Detalles');
        $Cantidad = $request->input('Cantidad');
        $Precio = $request->input('Precio');
        $TotalArt = $request->input('Total');
        $Total = $request->input('valor-total');
        $User = $request->input('user');
        $idPedido = $request->input('numero');
        $Codigo = $request->input('Codigo');
        $Estado = 'Espera';

        try {
            try {

                $pedido = [
                    'Cliente' => $Cliente,
                    'Fecha' => $Fecha,
                    'Estado' => $Estado,
                    'idUsuario' => $User
                ];

                Pedido::create($pedido);
            } catch (Exception $e) {
                return redirect()->back()->with(['resultado' => 'Error en el Pedido']);
            }

            try {


                for ($x = 0; $x < count($Detalles); $x++) {
                    $detalle = [
                        'idPedido' => $idPedido,
                        'DetallesTem' => $Detalles[$x],
                        'idProducto' => $Codigo[$x],
                        'Cantidad' => $Cantidad[$x],
                        'Precio' => $Precio[$x],
                        'Total' => $TotalArt[$x],
                        'Fecha' => $Fecha,
                    ];

                    PedidoDetalle::create($detalle);
                }
            } catch (Exception $e) {
                return redirect()->back()->with(['resultado' => 'Error en los detalles']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['resultado' => 'Error en Todo']);
        }




        return redirect()->back()->with(['success' => 'Pedido agregado correctamente']);
    }
    public function buscar($Fecha1, $Fecha2)
    {
        if ($Fecha1 != 'fecha1' && $Fecha1 != 'fecha2') {
            $data = PedidoDetalle::select('DetallesTem', PedidoDetalle::raw('SUM(Cantidad) as Cantidad, SUM(Total) as Total'))->whereBetween('Fecha', [$Fecha1, $Fecha2])->groupBy('DetallesTem')->get();
        } else {
            $data = PedidoDetalle::select('DetallesTem', PedidoDetalle::raw('SUM(Cantidad) as Cantidad, SUM(Total) as Total'))->groupBy('DetallesTem')->get();
        }

        return response()->json($data);
    }
    public function pdf($Fecha1, $Fecha2)
    {
        if ($Fecha1 != 'fecha1' && $Fecha1 != 'fecha2') {
            $Fechas = ['Inicio' => $Fecha1, 'Fin' => $Fecha2];
            $data = PedidoDetalle::select('DetallesTem', PedidoDetalle::raw('SUM(Cantidad) as Cantidad, SUM(Total) as Total'))->whereBetween('Fecha', [$Fecha1, $Fecha2])->groupBy('DetallesTem')->get();
        } else {
            $Fechas = ['Inicio' => 'TODO', 'Fin' => 'TODO'];
            $data = PedidoDetalle::select('DetallesTem', PedidoDetalle::raw('SUM(Cantidad) as Cantidad, SUM(Total) as Total'))->groupBy('DetallesTem')->get();
        }
        $pdf = Pdf::loadView('Pedidos.Buscarpdf', compact('data', 'Fechas'));
        return $pdf->stream('pedidos.pdf');
    }
    public function buscarAll($Fecha1, $Fecha2)
    {
        if ($Fecha1 != 'fecha1' && $Fecha1 != 'fecha2') {
            $data = Pedido::whereBetween('Fecha', [$Fecha1, $Fecha2])->orderBy('id','desc')->get();
        } else {
            $data = Pedido::orderBy('id','desc')->get();
        }

        return response()->json($data);
    }
    public function pdfAll($Fecha1, $Fecha2)
    {
        if ($Fecha1 != 'fecha1' && $Fecha1 != 'fecha2') {
            $Fechas = ['Inicio' => $Fecha1, 'Fin' => $Fecha2];
            $data = Pedido::join('pedido_detalles', 'pedido_detalles.idPedido', '=', 'pedidos.id')->select('pedidos.Cliente', 'pedido_detalles.DetallesTem', 'pedido_detalles.Cantidad')->whereBetween('pedidos.Fecha', [$Fecha1, $Fecha2])->groupBy('pedidos.Cliente', 'pedido_detalles.DetallesTem', 'pedido_detalles.Cantidad')->get();
        } else {
            $Fechas = ['Inicio' => 'TODO', 'Fin' => 'TODO'];
            $data = Pedido::join('pedido_detalles', 'pedido_detalles.idPedido', '=', 'pedidos.id')->select('pedidos.Cliente', 'pedido_detalles.DetallesTem', 'pedido_detalles.Cantidad')->groupBy('pedidos.Cliente', 'pedido_detalles.DetallesTem', 'pedido_detalles.Cantidad')->get();
        }
        $nombre = [];

        for ($x = 0; $x < count($data); $x++) {
            $nombre[$x] = $data[$x]['Cliente'];
        }
        $nombref = array_unique($nombre);
        $pdf = Pdf::loadView('Pedidos.BuscarAllpdf', compact('data', 'nombref', 'Fechas'));
        return $pdf->stream('pedidos.pdf');
    }

    public function vistaActualizar($id)
    {
        $ref = Factura::select('id')->orderBy('id', 'desc')->first();
        $Numero = $ref['id'];
        $Clientes = Cliente::select('id', 'Nombre', 'Identificador')->get();
        $Dinfo = PedidoDetalle::join('pedidos', 'pedidos.id', '=', 'pedido_detalles.idPedido')->select('pedidos.id', 'pedidos.Fecha', 'pedidos.Cliente', 'pedidos.idUsuario', 'pedidos.Estado', 'pedido_detalles.id as idDetalles', 'pedido_detalles.DetallesTem', 'pedido_detalles.Cantidad', 'pedido_detalles.Precio', 'pedido_detalles.Total', 'pedido_detalles.idProducto')->where('idPedido', $id)->get();
        /* dd($Dinfo); */
        return view('Pedidos.Actualizar', compact('Dinfo', 'Clientes', 'Numero'));
    }
    public function borrarElemento($id)
    {
        try {
            $borrarElemento = PedidoDetalle::find($id);
              $borrarElemento->delete();

            return response()->json(['resultado' => 'Borrado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['resultado' => 'Error al borrar']);
        }
    }
    public function procesar(Request $request)
    {
        $query = Producto::select('id')->get();
        $factura = [];
        $detalles = [];

        $Codigo = $request->input('Codigo');
        $Detalles = $request->input('Detalles');
        $Cantidad = $request->input('Cantidad');
        $Precio = $request->input('Precio');
        $Fecha = $request->input('Fecha');
        $idCliente = $request->input('idCliente');
        $Factura = $request->input('Factura');
        $Total = $request->input('Total');
        $IndividualTotal = $request->input('valor-total');
        $idPedido = $request->input('numero');
        $user = $request->input('user');
        $comp = [];

        for ($x = 0; $x < count($query); $x++) {
            $comp[$x] = $query[$x]['id'];
        }

        for ($x = 0; $x < count($Codigo); $x++) {

            if (!in_array($Codigo[$x], $comp)) {
                return response()->json([
                    'Estado' => 'Error', 'Mensaje' => 'El Articulo: ' . $Detalles[$x] . '  no existe, debes registrarlo. '
                ]);
            }
        }


        try {

            try {

                $factura = [
                    'idCliente' => $idCliente,
                    'Fecha' => $Fecha,
                    'Estado' => 'Cancelada',
                    'VendidoA' => str_replace(".", "", $IndividualTotal),
                    'PagadoA' => str_replace(".", "", $IndividualTotal),
                    'VendidoB' => 0,
                    'PagadoB' => 0,
                    'idUsuario' => $user,
                ];


                Factura::create($factura);
            } catch (Exception $e) {
                return response()->json(['resultado' => 'Error en la carga de la factura']);
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
                return response()->json(['resultado' => 'Error en la carga de los detalles']);
            }
            try {
                $ActualizarP = Pedido::find($idPedido);
                $ActualizarP->Estado = 'Procesada';
                $ActualizarP->save();
            } catch (Exception $e) {
                return response()->json(['resultado' => 'Error en la actualzacion del pedido']);
            }

            return response()->json([
                'Estado' => 'success', 'Mensaje' => 'Procesada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json(['resultado' => 'Error al borrar']);
        }
    }

    public function validarCantidad($refCantidad,$refCodigo){

        /* $validar = Producto::select('id','Stock')->where($ref[$x],) */

    }
}
