<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class ProductoController extends Controller
{
  
    public function index()
    {

        return view('Productos.Principal');
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
            return response()->json($validado->errors(),422);
            
        }else{
          
           
            try{
    
                $Producto = [
                    'Detalles'=>$request->input('Detalles'),
                    'Stock'=>$request->input('Stock'),
                    'PrecioCompra'=>$request->input('PrecioCompra'),
                    'PrecioVenta'=>$request->input('PrecioVenta'),
                    'Unidad'=>$request->input('idUnidad'),
                    'Fecha'=>$request->date('Fecha'),
                    'idProveedor'=>$request->input('idProveedor'),
                    'idCategoria'=>$request->input('idCategoria'),];
    
                Producto::create($Producto);
                return response()->json([
                    'titulo' => $Producto,
                    'Mensaje' => $request->all(),
                ]);
            }catch(Exception $e){
                return response()->json([
                    'titulo' => $Producto,
                    'Mensaje' => 'MALLL',
                ]);
            }
        }

      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        $datos = Producto::join('proveedores','proveedores.id','=','productos.idProveedor')
        ->join('categorias','categorias.id','=','productos.idCategoria')
        ->select('productos.id','productos.Detalles','productos.Stock','productos.PrecioCompra','productos.Unidad','productos.PrecioVenta','proveedores.Nombre','categorias.Descripcion')->get();
       
        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('op', function($row){
          $btn= '<a data-toggle="modal" data-target="#productos-modal" onclick="editar('.$row->id.')" class="btn btn-primary">ver</a>'; 
          $btn .= '<buttom value="'.$row->id.'"  onclick="borrar('.$row->id.')" class="btn btn-danger" id="btnborrar">Borrar</buttom>'; 
          return $btn;
        })->rawColumns(['op'])->toJson();
     
       return $Tabla;
    }

    public function view()
    {
        $Categorias = Categoria::all();
       $Proveedor = Proveedor::select('id','Nombre')->get();
        return view('Productos.Agregar',['Proveedor'=>$Proveedor,'Categoria'=>$Categorias]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = Producto::find($id);
        return response()->json([
            'hola' => 0,
            'Mensaje' => $datos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validado = Validator::make($request->all(), [
            'Detalles' => 'required',
            'Stock' => 'required',
            'PrecioCompra' => 'required',
            'PrecioVenta' => 'required',
            'idUnidad' => 'required',
            'Fecha' => 'required',
        ]); 
        
        if ($validado->fails()) {
            return response()->json($validado->errors(),422);
            
        }else{
          
           
            try{
    
                $update = Producto::find($id);
                $update->Detalles= $request->input('Detalles');
                $update->Stock = $request->input('Stock');
                $update->PrecioCompra = $request->input('PrecioCompra');
                $update->PrecioVenta = $request->input('PrecioVenta');
                $update->Unidad = $request->input('idUnidad');
                $update->Fecha = $request->input('Fecha');
        
                $update->update();
                return response()->json([
                    'titulo' => 'estado',
                    'Mensaje' => $request->all(),
                ]);
            }catch(Exception $e){
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

        return response()->json(['Error'=>0,'Mensaje'=>'Borrado']);
    }

    public function autocompletado(Request $request)
    {
        $posts = Producto::select('id', 'Detalles', 'Stock', 'PrecioVenta','Unidad')->where('Detalles', 'LIKE', '%' . $request->nombre . '%')->get();
        return response()->json($posts);
    }
    public function stockminimo()
    {
        $datosM = Producto::join('proveedores','proveedores.id','=','productos.idProveedor')
        ->select('productos.id','productos.Detalles','productos.Stock','proveedores.Nombre')->where('Stock','<=',10)->get();
       

      
        return view('Productos.Minimo',compact('datosM'));
    }


}
