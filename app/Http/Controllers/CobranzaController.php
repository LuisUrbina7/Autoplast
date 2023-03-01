<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Detalles;
use App\Models\Cliente;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class CobranzaController extends Controller
{
    public function index()
    {
       
       return view('Cobranza.Zona'); 
    }
    public function zona($zona)
    {
        $datos = Factura::join('clientes','clientes.id','=','ventas.idCliente')
        ->select('clientes.id','clientes.nombre','clientes.identificador',Factura::raw('SUM(vendido_A-pagado_A) as COL,SUM(vendido_B-pagado_B) as USD'))->where('clientes.zona',$zona)->groupBy('clientes.id','clientes.nombre','clientes.identificador')->get();
    
       /*  dd($datos); */
       return view('Cobranza.Principal',compact('datos')); 
    }
    public function show($id)
    {
        $Factura = Factura::select('id','idCliente','fecha','vendido_A','pagado_A','vendido_B','pagado_B','estado')->where('idCliente',$id)->get();
       
        return view('Cobranza.Facturas',compact('Factura'));
    }
    
    public function destroy($id)
    {
        try {
            $detalles = Detalles::select('idfactura', 'cantidad', 'idProducto')->where('idfactura', $id)->get();
         
            for ($x = 0; $x < count($detalles); $x++) {
                $producto = Producto::find($detalles[$x]['idProducto']);
                $producto->stock += $detalles[$x]['cantidad'];
                $producto->save();
            }
            $delete = Factura::find($id);
            $delete->delete();

            return response()->json([
                'titulo' => 'Datos',
                'Mensaje' => 'borrado Correctamente',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'titulo' => 'Datos',
                'Mensaje' => $e,
            ]);
        }
      
    }
    public function buscarDetalles($idCliente, $idFactura){

      /*   dd($idFactura+$nombre);
         */
      
        $factura = Factura::join('clientes','clientes.id','=','ventas.idCliente')->select('ventas.id','ventas.idCliente','ventas.fecha','ventas.vendido_A','ventas.pagado_A','ventas.vendido_B','ventas.pagado_B','ventas.estado', 'clientes.nombre','clientes.apellido','clientes.identificador','clientes.zona','clientes.direccion','clientes.telefono')->where('ventas.id',$idFactura)->get();
        $productos = Detalles::where('idfactura',$idFactura)->get();
       
   
       return view('Cobranza.Detalles',compact('factura','productos'));
    }
    public function generarpdf($idCliente, $idFactura){
        
        $detalles = Detalles::where('idfactura',$idFactura)->get();
        $cliente = Cliente::where('id',$idCliente)->first();
        $factura = Factura::where('id',$idFactura)->first();
     
       $pdf = Pdf::loadView('Cobranza.Cobranzapdf',compact('factura','cliente','detalles'));
     /*   return view('Cobranza.Cobranzapdf',compact('facturas','clientes','detalles')); */
           return $pdf->stream('prueba.pdf');
      }
    

}
