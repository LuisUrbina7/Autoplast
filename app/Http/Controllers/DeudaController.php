<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\Detalles_compras;
use App\Models\Producto;
use App\Models\Proveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class DeudaController extends Controller
{
    public function index()
    {
        $Proveedores = Compras::join('proveedores', 'proveedores.id', '=', 'compras.idProveedor')
            ->select('proveedores.id', 'proveedores.Nombre', Compras::raw('SUM(VendidoA-PagadoA) as COL,SUM(VendidoB-PagadoB) as USD'))
            ->groupBy('proveedores.id', 'proveedores.Nombre')->get();

        return view('Deuda.Principal', compact('Proveedores'));
    }
    public function show($id)
    {
        $Factura = Compras::select('id', 'idProveedor', 'Fecha', 'VendidoA', 'PagadoA', 'VendidoB', 'PagadoB', 'Estado')->where('idProveedor', $id)->get();
        return view('Deuda.Facturas', compact('Factura'));
    }
    public function destroy($id)
    {
       
        try {
            $detalles = Detalles_compras::select('idfactura', 'Cantidad', 'idProducto')->where('idfactura', $id)->get();
         
            for ($x = 0; $x < count($detalles); $x++) {
                $producto = Producto::find($detalles[$x]['idProducto']);
                $producto->Stock -= $detalles[$x]['Cantidad'];
                $producto->save();
            }
            $delete = Compras::find($id);
            $delete->delete();

            return response()->json([
                'titulo' => 'Datos',
                'Mensaje' => 'borrado Correctamente',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'titulo' => 'Datos',
                'Mensaje' => 'Error',
            ]);
        }
        
    }
    public function buscarDetalles($idProveedor, $idFactura)
    {

        /*   dd($idFactura+$nombre);
           */
        $proveedor = Proveedor::where('id', $idProveedor)->get();
        $detalles = Detalles_compras::where('idfactura', $idFactura)->get();

        $factura = Compras::where('id', $idFactura)->get();
        return view('Deuda.Detalles', compact('detalles', 'proveedor', 'factura'));
    }
    public function generarpdf($idCliente, $idFactura)
    {

        $detallesC = Detalles_compras::where('idfactura', $idFactura)->get();
        $proveedors = Proveedor::where('id', $idCliente)->get();
        $Compras = Compras::where('id', $idFactura)->get();

        $pdf = Pdf::loadView('Deuda.Deudapdf', compact('Compras', 'proveedors', 'detallesC'));
        /*   return view('Cobranza.Cobranzapdf',compact('facturas','clientes','detalles')); */
        return $pdf->stream('Compras.pdf');
    }
}
