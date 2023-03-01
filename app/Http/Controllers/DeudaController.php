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
            ->select('proveedores.id', 'proveedores.nombre', Compras::raw('SUM(vendido_A-pagado_A) as COL,SUM(vendido_B-pagado_B) as USD'))
            ->groupBy('proveedores.id', 'proveedores.nombre')->get();

        return view('Deuda.Principal', compact('Proveedores'));
    }
    public function show($id)
    {
        $Factura = Compras::select('id', 'idProveedor', 'fecha', 'vendido_A', 'pagado_A', 'vendido_B', 'pagado_B', 'estado')->where('idProveedor', $id)->get();
        return view('Deuda.Facturas', compact('Factura'));
    }
    public function destroy($id)
    {
       
        try {
            $detalles = Detalles_compras::select('idfactura', 'cantidad', 'idProducto')->where('idfactura', $id)->get();
         
            for ($x = 0; $x < count($detalles); $x++) {
                $producto = Producto::find($detalles[$x]['idProducto']);
                $producto->stock -= $detalles[$x]['Cantidad'];
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

        $detalles = Detalles_compras::select('idfactura','idProducto','cantidad','precio','total')->where('idfactura', $idFactura)->get();
        $proveedores = Proveedor::select('nombre','direccion','telefono')->where('id', $idCliente)->get();
        $factura = Compras::where('id', $idFactura)->first();
/* dd($factura['id']); */
        $pdf = Pdf::loadView('Deuda.Deudapdf', compact('factura', 'proveedores', 'detalles'));
         /*  return view('Deuda.Deudapdf',compact('factura','proveedores','detalles')); */
        return $pdf->stream('Compras.pdf');
    }
}
