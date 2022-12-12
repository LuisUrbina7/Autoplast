<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Proveedores.Principal');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validado = Validator::make($request->all(), [
            'Nombre' => 'unique:proveedores|required',
            'Direccion' => 'required',
            'Telefono' => 'required',
        ]);

        if ($validado->fails()) {
            return response()->json($validado->errors(), 422);
        } else {
            $data = new Proveedor;
            $data->Nombre = $request->input('Nombre');
            $data->Direccion = $request->input('Direccion');
            $data->Telefono = $request->input('Telefono');
            $data->save();
            return response()->json([
                'titulo' => 'Datos',
                'Mensaje' => $data,
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
        $datos = Proveedor::all();
        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('Prueba', function ($row) {
            $btn = '<a data-toggle="modal" data-target="#proveedores-modal" onclick="editar(' . $row->id . ')" class="btn btn-primary">ver</a>';
            $btn .= '<buttom value="' . $row->id . '"  onclick="borrar(' . $row->id . ')" class="btn btn-danger" id="btnborrar">Borrar</buttom>';
            return $btn;
        })->rawColumns(['Prueba'])->toJson();

        return $Tabla;
    }

    public function view()
    {
        return view('Proveedores.Agregar');
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
        $datos = Proveedor::find($id);
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
            'Nombre' => 'required',
            'Direccion' => 'required',
            'Telefono' => 'required',
        ]);

        if ($validado->fails()) {
            return response()->json($validado->errors(), 422);
        } else {
            $update = Proveedor::find($id);
            $update->Nombre = $request->input('Nombre');
            $update->Direccion = $request->input('Direccion');
            $update->Telefono = $request->input('Telefono');
            $update->update();
            return response()->json(['Estado' => 0, 'Mensaje' => $update]);
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
        $delete = Proveedor::find($id);
        $delete->delete();
        return response()->json(['Error' => 0, 'Mensaje' => 'Borrado']);
    }
}
