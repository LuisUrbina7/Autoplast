<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Usuarios = User::count();
        $Productos = Producto::count();
        $Clientes = Cliente::count();

        return view('Inicio.Principal',compact('Usuarios','Productos','Clientes'));
    }
    public function ventas()
    {
        $ventas = DB::table('facturas_ventas')
        ->select(DB::raw('sum(VendidoA) as TotalA,sum(VendidoB) as TotalB, Estado as estado'))
        ->groupBy('Estado')
        ->get();
        $inventario = DB::table('productos')
        ->select(DB::raw('sum(PrecioCompra*Stock) as Inventario'))
        ->get();
      
        return response()->json(['ventas'=>$ventas,'inventario'=>$inventario]);
    }
    public function grafico()
    {
        $grafico = DB::table('facturas_ventas')
        ->select(DB::raw('sum(VendidoA - PagadoA) as CobranzaA, sum(VendidoB - PagadoB) as CobranzaB'))
        ->get();
        $data = Pedido::join('users','users.id','=','pedidos.idUsuario')->select('pedidos.Cliente','pedidos.Fecha','pedidos.id','users.username','users.name')->orderBy('id','desc')->get();
        return response()->json(['grafico'=>$grafico,'data'=>$data]);
    }

}
