<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ClienteController extends Controller
{

    public function index()
    {
        return view('Clientes.Principal');
    }
    public function create(Request $request)
    {

        $validado = Validator::make($request->all(), [
            'Nombre' => 'required',
            'Apellido' => 'required',
            'Identificador' => 'required | unique:clientes',
            'Zona' => 'required',
            'Direccion' => 'required',
            'Telefono' => 'required',
        ]);

        if ($validado->fails()) {
           /*  dd($validado->errors()); */
            return redirect()->back()->withErrors($validado->errors());
        } else {

            try{
                
                $cliente = new Cliente;
                $cliente->Nombre = $request->input('Nombre');
                $cliente->Apellido = $request->input('Apellido');
                $cliente->Identificador = $request->input('Identificador');
                $cliente->Zona = $request->input('Zona');
                $cliente->Direccion = $request->input('Direccion');
                $cliente->Telefono = $request->input('Telefono');
                $cliente->save();
    
                return redirect()->back()->with(['Excelente' => 'Datos guardado con éxito.']);
            }catch(Exception $e){
                return redirect()->back()->with(['Error'=>'Algo ocurrió, inténato más tarde.']);
            }
        }
    }
    public function listar()
    {
        $datos = Cliente::all();
        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('opciones', function ($row) {
            $btn = '<buttom data-toggle="modal" data-target="#clientes-modal" class="text-success" id="btnver" >ver</buttom> | ';
            $btn .= '<buttom value="' . $row->id . '"  onclick="borrar(' . $row->id . ')" class="text-danger" id="btnborrar">Borrar</buttom>';
            return $btn;
        })->rawColumns(['opciones'])->toJson();

        return $Tabla;
    }

    public function view()
    {
        return view('Clientes.Agregar');
    }

    public function update(Request $request, $id)
    {

        $validado = Validator::make($request->all(), [
            'Nombre' => 'required',
            'Apellido' => 'required',
            'Identificador' => 'required',
            'Zona' => 'required',
            'Direccion' => 'required',
            'Telefono' => 'required',
        ]);

        if ($validado->fails()) {
            return response()->json($validado->errors(), 422);
        } else {
            $update = Cliente::find($id);
            $update->Nombre = $request->input('Nombre');
            $update->Apellido = $request->input('Apellido');
            $update->Identificador = $request->input('Identificador');
            $update->Zona = $request->input('Zona');
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
        $delete = Cliente::find($id);

        $delete->delete();

        return response()->json(['Error' => 0, 'Mensaje' => 'Borrado']);
    }
}
