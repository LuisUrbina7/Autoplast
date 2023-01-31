<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Compras;
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

        return view('Inicio.Principal', compact('Usuarios', 'Productos', 'Clientes'));
    }
    public function ventas()
    {
        $ventas = DB::table('facturas_ventas')
            ->select(DB::raw('sum(VendidoA)  as Cancelada,sum(VendidoB)  as Credito, Estado as estado'))
            ->groupBy('Estado')
            ->get();

        $inventario = Producto::select(DB::raw('sum(PrecioCompra*Stock) as Inventario'))->groupBy('Ruta')
            ->get();
       /*  dd($inventario); */
        return response()->json(['ventas' => $ventas, 'inventario' => $inventario]);
    }
    public function grafico()
    {
        $grafico = DB::table('facturas_ventas')
            ->select(DB::raw('sum(VendidoA - PagadoA) as CobranzaA, sum(VendidoB - PagadoB) as CobranzaB'))
            ->get();
        $data = Pedido::join('users', 'users.id', '=', 'pedidos.idUsuario')->select('pedidos.Cliente', 'pedidos.Fecha', 'pedidos.id', 'users.username', 'users.name')->orderBy('id', 'desc')->limit(3);
        return response()->json(['grafico' => $grafico, 'data' => $data]);
    }
    public function grafico_barras(){
        $datos = array(Factura::count(), Compras::count());


        return  response()->json($datos);
    }
}
