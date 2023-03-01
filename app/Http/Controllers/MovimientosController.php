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
            $data = Factura::join('clientes','clientes.id','=','ventas.idCliente')
            ->select('ventas.id','ventas.fecha','ventas.estado','ventas.vendido_A','ventas.pagado_A','ventas.vendido_B','ventas.pagado_B','clientes.nombre','clientes.id as clientesid')->whereBetween('fecha',[$Fecha1,$Fecha2])->get();
        
        
           } else {
               $data = Factura::join('clientes','clientes.id','=','ventas.idCliente')
               ->select('ventas.id','ventas.fecha','ventas.estado','ventas.vendido_A','ventas.pagado_A','ventas.vendido_B','ventas.pagado_B','clientes.nombre','clientes.id as clientesid')->get();
               
            }
            return response()->json($data);
    }
    public function buscarEntrada($Fecha1,$Fecha2){

        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') {
            $data = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.fecha','compras.estado','compras.vendido_A','compras.pagado_A','compras.Vendido_B','compras.pagado_B','proveedores.nombre','proveedores.id as proveedoresid')->whereBetween('fecha',[$Fecha1,$Fecha2])->get();
            
        } else {
            $data = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.fecha','compras.estado','compras.vendido_A','compras.pagado_A','compras.vendido_B','compras.pagado_B','proveedores.nombre','proveedores.id as proveedoresid')->get();
        
            
        }
        return response()->json($data);
    }
    public function pdfSalida($Fecha1,$Fecha2){

        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') {
       $Fechas= ['Inicio'=>$Fecha1, 'Fin'=>$Fecha2];
         $Facturas = Factura::join('clientes','clientes.id','=','ventas.idCliente')
         ->select('ventas.id','ventas.fecha','ventas.estado','ventas.vendido_A','ventas.pagado_A','ventas.vendido_B','ventas.pagado_B','clientes.nombre','clientes.id as clientesid')->whereBetween('fecha',[$Fecha1,$Fecha2])->get();
        }else{
            $Fechas= ['Inicio'=>'TODO', 'Fin'=>'TODO'];
            $Facturas = Factura::join('clientes','clientes.id','=','ventas.idCliente')
         ->select('ventas.id','ventas.fecha','ventas.estado','ventas.vendido_A','ventas.pagado_A','ventas.vendido_B','ventas.pagado_B','clientes.nombre','clientes.id as clientesid')->get();
        }
        $pdf = Pdf::loadView('Movimientos.Salidaspdf',compact('Facturas','Fechas'));
        return $pdf->stream('prueba.pdf');
     }
    public function pdfEntrada($Fecha1,$Fecha2){
        if ($Fecha1!='fecha1' && $Fecha1!='fecha2') { 
       $Fechas= ['Inicio'=>$Fecha1, 'Fin'=>$Fecha2];
         $Facturas = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
         ->select('compras.id','compras.fecha','compras.estado','compras.vendido_A','compras.pagado_A','compras.vendido_B','compras.pagado_B','proveedores.nombre','proveedores.id as proveedoresid')->whereBetween('fecha',[$Fecha1,$Fecha2])->get();
        }else{
            $Fechas= ['Inicio'=>'TODO', 'Fin'=>'TODO'];
            $Facturas = Compras::join('proveedores','proveedores.id','=','compras.idProveedor')
            ->select('compras.id','compras.fecha','compras.estado','compras.vendido_A','compras.pagado_A','compras.vendido_B','compras.pagado_B','proveedores.nombre','proveedores.id as proveedoresid')->get();
        }
        $pdf = Pdf::loadView('Movimientos.Entradaspdf',compact('Facturas','Fechas'));
        return $pdf->stream('prueba.pdf');
      
     }
}
