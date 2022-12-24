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
        $datos = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')
        ->select('clientes.id','clientes.Nombre','clientes.Identificador',Factura::raw('SUM(VendidoA-PagadoA) as COL,SUM(VendidoB-PagadoB) as USD'))->where('clientes.Zona',$zona)->groupBy('clientes.id','clientes.Nombre','clientes.Identificador')->get();
    
       /*  dd($datos); */
       return view('Cobranza.Principal',compact('datos')); 
    }
    public function show($id)
    {
        $Factura = Factura::select('id','idCliente','Fecha','VendidoA','PagadoA','VendidoB','PagadoB','Estado')->where('idCliente',$id)->get();
       
        return view('Cobranza.Facturas',compact('Factura'));
    }
    
    public function destroy($id)
    {
        try {
            $detalles = Detalles::select('idfactura', 'Cantidad', 'idProducto')->where('idfactura', $id)->get();
         
            for ($x = 0; $x < count($detalles); $x++) {
                $producto = Producto::find($detalles[$x]['idProducto']);
                $producto->Stock += $detalles[$x]['Cantidad'];
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
      
        $factura = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')->select('facturas_ventas.id','facturas_ventas.idCliente','facturas_ventas.Fecha','facturas_ventas.VendidoA','facturas_ventas.PagadoA','facturas_ventas.VendidoB','facturas_ventas.PagadoB','facturas_ventas.Estado', 'clientes.Nombre','clientes.Apellido','clientes.Identificador','clientes.Zona','clientes.Direccion','clientes.Telefono')->where('facturas_ventas.id',$idFactura)->get();
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
