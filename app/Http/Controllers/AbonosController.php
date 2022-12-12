<?php

namespace App\Http\Controllers;

use App\Models\AbonoCompra;
use App\Models\Abonos;
use App\Models\Compras;
use App\Models\Factura;
use Illuminate\Http\Request;

class AbonosController extends Controller
{

  public function cargarA($id)
  {
    $Abonos = Abonos::select('id', 'Fecha', 'Monto')->where('idFactura', $id)->get();

    return response()->json($Abonos);
  }
  public function cargarB($id)
  {
    $Abonos = AbonoCompra::select('id', 'Fecha', 'Monto')->where('idFactura', $id)->get();

    return response()->json($Abonos);
  }
  public function agregarA(Request $request)
  {

    $Abonos = new Abonos;
    $Fecha = $request->input('Fecha');
    $Deuda = $request->input('Deuda');
    $Monto = $request->input('Monto');
    $Estado = '';
    $idFactura = $request->input('idFactura');



    if ($Monto <= 0) {
      return   back();
    } else {

      if ($Monto == $Deuda) {
        $Estado = 'Cancelada';
      } else {
        $Estado = 'Credito';
      }

      $Abonos->Fecha = $Fecha;
      $Abonos->Monto = $Monto;
      $Abonos->idFactura = $idFactura;
      $Abonos->save();
      $this->actualizarA($idFactura, $Monto, $Estado);

      return   back();
    }
  }
  public function agregarB(Request $request)
  {

    $Abonos = new AbonoCompra;
    $Fecha = $request->input('Fecha');
    $Deuda = $request->input('Deuda');
    $Monto = $request->input('Monto');
    $Estado = '';
    $idFactura = $request->input('idFactura');



    if ($Monto <= 0) {
      return   back();
    } else {

      if ($Monto == $Deuda) {
        $Estado = 'Cancelada';
      } else {
        $Estado = 'Credito';
      }

      $Abonos->Fecha = $Fecha;
      $Abonos->Monto = $Monto;
      $Abonos->idFactura = $idFactura;
      $Abonos->save();
      $this->actualizarB($idFactura, $Monto, $Estado);

      return   back();
    }
  }

  public function actualizarA($id, $monto, $estado)
  {

    $factura =  Factura::find($id);
    if ($factura) {
      if ($factura->VendidoA == 0) {
        $factura->PagadoB += $monto;
      } else {
        $factura->PagadoA += $monto;
      
      }
      $factura->Estado = $estado;
      $factura->save();
    } else {
      echo 'error';
  
    }
  
  }
  public function actualizarB($id, $monto, $estado)
  {
    $factura =  Compras::find($id);
    if ($factura) {
      if ($factura->VendidoA == 0) {
        $factura->PagadoB += $monto;
      } else {
        $factura->PagadoA += $monto;
      
      }
      $factura->Estado = $estado;
      $factura->save();
    } else {
      echo 'error';
  
    }
  }
}
