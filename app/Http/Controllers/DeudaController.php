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

        $detalles = Detalles_compras::select('idfactura','idProducto','Cantidad','Precio','Total')->where('idfactura', $idFactura)->get();
        $proveedores = Proveedor::select('Nombre','Direccion','Telefono')->where('id', $idCliente)->get();
        $factura = Compras::where('id', $idFactura)->first();
/* dd($factura['id']); */
        $pdf = Pdf::loadView('Deuda.Deudapdf', compact('factura', 'proveedores', 'detalles'));
         /*  return view('Deuda.Deudapdf',compact('factura','proveedores','detalles')); */
        return $pdf->stream('Compras.pdf');
    }
}
