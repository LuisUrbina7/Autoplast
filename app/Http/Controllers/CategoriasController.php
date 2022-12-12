<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Categorias.Principal');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validado = Validator::make($request->all(), [
            'Descripcion' => 'unique:categorias',
        ]); 
        
        if ($validado->fails()) {
            return response()->json($validado->errors(),422);
            
        }else{
        $categoria= new Categoria;

        $categoria->Descripcion = $request->input('Descripcion');
      

        $categoria->save();

        return response()->json([
            'titulo' => 'Datos',
            'Mensaje' => $categoria,
        ]);
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
        $datos = Categoria::all();
        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('Prueba', function($row){
          $btn= '<a data-toggle="modal" data-target="#categorias-modal2" onclick="editar('.$row->id.')" class="btn btn-primary">ver</a>'; 
          $btn .= '<buttom value="'.$row->id.'"  onclick="borrar('.$row->id.')" class="btn btn-danger" id="btnborrar">Borrar</buttom>'; 
          return $btn;
        })->rawColumns(['Prueba'])->toJson();

        return $Tabla;
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = Categoria::find($id);
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
            'Descripcion' => 'unique:categorias',
        ]); 
        
        if ($validado->fails()) {
            return response()->json($validado->errors(),422);
            
        }else{
        $update = Categoria::find($id);
        $update->Descripcion = $request->input('Descripcion');
        $update->update();

        return response()->json(['Estado'=>0,'Mensaje'=>$update]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Categoria::find($id);
        
        $delete->delete();

        return response()->json(['Error'=>0,'Mensaje'=>'Borrado']);
    }
}
