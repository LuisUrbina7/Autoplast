<?php

namespace App\Http\Controllers;

use App\Imports\ProductosImport;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{

    public function index()
    {
        $Categorias = Categoria::all();
        $Proveedores = Proveedor::select('id', 'nombre')->get();
        
        return view('Productos.Principal', compact('Proveedores', 'Categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validado = Validator::make($request->all(), [
            'Detalles' => 'unique:productos',
            'Stock' => 'required',
            'PrecioCompra' => 'required',
            'PrecioVenta' => 'required',
            'idUnidad' => 'required',
            'Fecha' => 'required',
            'idProveedor' => 'required',
            'idCategoria' => 'required',
        ]);

        if ($validado->fails()) {
            return response()->json($validado->errors(), 422);
        } else {

            try {
             
                $Producto = [
                    'detalles' => $request->input('Detalles'),
                    'stock' => str_replace(",",".",$request->input('Stock')) ,
                    'costo' => str_replace(",",".",$request->input('PrecioCompra')),
                    'venta' => str_replace(",",".",$request->input('PrecioVenta')),
                    'unidad' => $request->input('idUnidad'),
                    'fecha' => $request->date('Fecha'),
                    'ruta' => $request->input('Ruta'),
                    'idProveedor' => $request->input('idProveedor'),
                    'idCategoria' => $request->input('idCategoria'),
                ];

                Producto::create($Producto);
                return response()->json([
                    'titulo' => $Producto,
                    'Mensaje' => $request->all(),
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'titulo' => $Producto,
                    'Mensaje' => $e,
                ]);
            }
        }
    }

    
    public function listar($ruta)
    {
     
        $datos = Producto::join('proveedores', 'proveedores.id', '=', 'productos.idProveedor')
            ->join('categorias', 'categorias.id', '=', 'productos.idCategoria')
            ->select('productos.id', 'productos.detalles', 'productos.stock', 'productos.costo', 'productos.unidad', 'productos.venta', 'proveedores.nombre', 'categorias.descripcion')->where('productos.ruta',$ruta)->get();

        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('opciones', function ($row) {
            $btn = '<div class="btn-group"><buttom data-bs-toggle="modal" data-bs-target="#productos-modal" onclick="editar(' . $row->id . ')" class="btn btn-primary"><i class="las la-pencil-alt fs-4"></i></buttom>';
            $btn .= '<buttom value="' . $row->id . '"  onclick="borrar(' . $row->id . ')" class="btn btn-danger" id="btnborrar"><i class="las la-broom fs-4"></i></buttom> </div>';
            return $btn;
        })->rawColumns(['opciones'])->toJson();

        return $Tabla;
    }

    public function view()
    {
        $Categorias = Categoria::all();
        $Proveedor = Proveedor::select('id', 'nombre')->get();
      
        return view('Productos.Agregar', ['Proveedores' => $Proveedor, 'Categorias' => $Categorias]);
    }

   
    public function edit($id)
    {
        $datos = Producto::find($id);
        return response()->json([
            'hola' => 0,
            'Mensaje' => $datos,
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $validado = Validator::make($request->all(), [
            'Detalles' => 'required',
            'Stock' => 'required',
            'Costo' => 'required',
            'Venta' => 'required',
            'idUnidad' => 'required',
            'Fecha' => 'required',
        ]);

        if ($validado->fails()) {
            return response()->json($validado->errors(), 422);
        } else {


            try {

                $producto = Producto::find($id);
                $producto->detalles = $request->input('Detalles');
                $producto->stock = str_replace(",",".",$request->input('Stock'));
                $producto->costo = str_replace(",",".",$request->input('Costo'));
                $producto->venta = str_replace(",",".",$request->input('Venta'));
                $producto->unidad = $request->input('idUnidad');
                $producto->fecha = $request->input('Fecha');
               /*  $producto->Ruta =  $request->input('Ruta'); */
                $producto->idProveedor = $request->input('idProveedor');
                $producto->idCategoria = $request->input('idCategoria');
                $producto->update();
                return response()->json([
                    'titulo' => 'estado',
                    'Mensaje' => $request->all(),
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'titulo' => 'Estado',
                    'Mensaje' => 'MALLL',
                ]);
            }
        }
    }


    public function destroy($id)
    {
        $delete = Producto::find($id);

        $delete->delete();

        return response()->json(['Error' => 0, 'Mensaje' => 'Borrado']);
    }

    public function autocompletado(Request $request, $id)
    {
        $posts = Producto::select('id', 'detalles', 'stock', 'venta', 'unidad')->where('ruta',$id)->where('detalles', 'LIKE', '%' . $request->nombre . '%')->get();
        return response()->json($posts);
    }
    public function stockminimo()
    {
        $datosM = Producto::join('proveedores', 'proveedores.id', '=', 'productos.idProveedor')
            ->select('productos.id', 'productos.detalles', 'productos.stock', 'proveedores.nombre')->where('stock', '<=', 5)->get();



        return view('Productos.Minimo', compact('datosM'));
    }
    public function importar(Request $request)
    {
        /*   try{  */
            $datos = Excel::import(new ProductosImport, $request->file('importar')->store('temp'));
      /*   dd($datos); */
             return redirect()->back()->with(['Excelente'=>'Datos subidos correctamente']); 
        /*  }catch(Exception $e){
           
         
        }  */
    }
}
