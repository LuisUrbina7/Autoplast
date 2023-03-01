<?php

namespace App\Http\Controllers;

use App\Imports\ClientesImport;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
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
                $cliente->nombre = $request->input('Nombre');
                $cliente->apellido = $request->input('Apellido');
                $cliente->identificador = $request->input('Identificador');
                $cliente->zona = $request->input('Zona');
                $cliente->direccion = $request->input('Direccion');
                $cliente->telefono = $request->input('Telefono');
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
            $btn = '<buttom data-bs-toggle="modal" data-bs-target="#clientes-modal" class="text-success"  onclick="editar(' . $row->id . ')" >ver</buttom> | ';
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
        } 
        try{

            $update = Cliente::find($id);
            $update->nombre = $request->input('Nombre');
            $update->apellido = $request->input('Apellido');
            $update->identificador = $request->input('Identificador');
            $update->zona = $request->input('Zona');
            $update->direccion = $request->input('Direccion');
            $update->telefono = $request->input('Telefono');
            $update->update();

            return response()->json(['Estado' => 0, 'Mensaje' => $update]);
        }catch(Exception $e){
            return response()->json(['Estado' => 0, 'Mensaje' => $e]);
        }
        
    }

    public function modal($id)
    {
        $datos = Cliente::find($id);
        return response()->json([
            'hola' => 0,
            'Mensaje' => $datos,
        ]);
    }
    public function destroy($id)
    {
        $delete = Cliente::find($id);

        $delete->delete();

        return response()->json(['Error' => 0, 'Mensaje' => 'Borrado']);
    }

    public function importar(Request $request)
    {
          try{ 
            $datos = Excel::import(new ClientesImport, $request->file('importar')->store('temp'));
      /*   dd($datos); */
             return redirect()->back()->with(['Excelente'=>'Datos subidos correctamente']); 
         }catch(Exception $e){
            return redirect()->back()->with(['Error'=>'Datos subidos correctamente']); 
            /* return $e; */
        } 
    }

}
