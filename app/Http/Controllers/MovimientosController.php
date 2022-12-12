<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    public function indexA(){
        return view('Movimientos.Salidas');
    }
    public function indexB(){
        return view('Movimientos.Entradas');
    }

    public function buscarSalida($Fecha1,$Fecha2){

        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') {
            $data = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')
            ->select('facturas_ventas.id','facturas_ventas.Fecha','facturas_ventas.Estado','facturas_ventas.VendidoA','facturas_ventas.PagadoA','facturas_ventas.VendidoB','facturas_ventas.PagadoB','clientes.Nombre','clientes.id as clientesid')->whereBetween('Fecha',[$Fecha1,$Fecha2])->get();
        
        
           } else {
               $data = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')
               ->select('facturas_ventas.id','facturas_ventas.Fecha','facturas_ventas.Estado','facturas_ventas.VendidoA','facturas_ventas.PagadoA','facturas_ventas.VendidoB','facturas_ventas.PagadoB','clientes.Nombre','clientes.id as clientesid')->get();
               
            }
            return response()->json($data);
    }
    public function buscarEntrada($Fecha1,$Fecha2){

        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') {
            $data = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.Fecha','compras.Estado','compras.VendidoA','compras.PagadoA','compras.VendidoB','compras.PagadoB','proveedores.Nombre','proveedores.id as proveedoresid')->whereBetween('Fecha',[$Fecha1,$Fecha2])->get();
            
        } else {
            $data = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.Fecha','compras.Estado','compras.VendidoA','compras.PagadoA','compras.VendidoB','compras.PagadoB','proveedores.Nombre','proveedores.id as proveedoresid')->get();
        
            
        }
        return response()->json($data);
    }
    public function pdfSalida($Fecha1,$Fecha2){

        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') {
       $Fechas= ['Inicio'=>$Fecha1, 'Fin'=>$Fecha2];
         $Facturas = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')
         ->select('facturas_ventas.id','facturas_ventas.Fecha','facturas_ventas.Estado','facturas_ventas.VendidoA','facturas_ventas.PagadoA','facturas_ventas.VendidoB','facturas_ventas.PagadoB','clientes.Nombre','clientes.id as clientesid')->whereBetween('Fecha',[$Fecha1,$Fecha2])->get();
        }else{
            $Fechas= ['Inicio'=>'TODO', 'Fin'=>'TODO'];
            $Facturas = Factura::join('clientes','clientes.id','=','facturas_ventas.idCliente')
         ->select('facturas_ventas.id','facturas_ventas.Fecha','facturas_ventas.Estado','facturas_ventas.VendidoA','facturas_ventas.PagadoA','facturas_ventas.VendidoB','facturas_ventas.PagadoB','clientes.Nombre','clientes.id as clientesid')->get();
        }
        $pdf = Pdf::loadView('Movimientos.Salidaspdf',compact('Facturas','Fechas'));
        return $pdf->stream('prueba.pdf');
     }
    public function pdfEntrada($Fecha1,$Fecha2){
        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') { 
       $Fechas= ['Inicio'=>$Fecha1, 'Fin'=>$Fecha2];
         $Facturas = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
         ->select('compras.id','compras.Fecha','compras.Estado','compras.VendidoA','compras.PagadoA','compras.VendidoB','compras.PagadoB','proveedores.Nombre','proveedores.id as proveedoresid')->whereBetween('Fecha',[$Fecha1,$Fecha2])->get();
        }else{
            $Fechas= ['Inicio'=>'TODO', 'Fin'=>'TODO'];
            $Facturas = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.Fecha','compras.Estado','compras.VendidoA','compras.PagadoA','compras.VendidoB','compras.PagadoB','proveedores.Nombre','proveedores.id as proveedoresid')->get();
        }
        $pdf = Pdf::loadView('Movimientos.Entradaspdf',compact('Facturas','Fechas'));
        return $pdf->stream('prueba.pdf');
      
     }
}
