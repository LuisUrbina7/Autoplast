<?php

namespace App\Http\Controllers;

use App\Imports\ProveedoresImport;
use App\Models\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProveedoresController extends Controller
{
    
    public function index()
    {
        return view('Proveedores.Principal');
    }

   
    public function create(Request $request)
    {
        $validado = Validator::make($request->all(), [
            'Nombre' => 'unique:proveedores'
        ]);

        if ($validado->fails()) {
            /* dd($validado->errors()); */
            return redirect()->back()->withErrors($validado->errors());
        } else {

            try {

                $data = new Proveedor;
                $data->nombre = $request->input('Nombre');
                $data->direccion = $request->input('Direccion');
                $data->telefono = $request->input('Telefono');
                $data->save();
                return redirect()->back()->with(['Excelente' => 'Datos guardado con éxito.']);
            } catch (Exception $e) {
                return redirect()->back()->with(['Error' => 'Algo ocurrió, inténato más tarde.']);
            }
        }
    }
    
    public function listar()
    {
        $datos = Proveedor::all();
        $Tabla = DataTables::of($datos)->addIndexColumn()->addColumn('Prueba', function ($row) {
            $btn = '<div class="btn-group"> <buttom data-bs-toggle="modal" data-bs-target="#proveedores-modal" onclick="editar(' . $row->id . ')" class="btn btn-primary"><i class="las la-pencil-alt fs-4"></i></buttom>';
            $btn .= '<buttom value="' . $row->id . '"  onclick="borrar(' . $row->id . ')" class="btn btn-danger" id="btnborrar"><i class="las la-broom fs-4"></i></buttom> </div>';
            return $btn;
        })->rawColumns(['Prueba'])->toJson();

        return $Tabla;
    }

    public function view()
    {
        return view('Proveedores.Agregar');
    }

    
    public function edit($id)
    {
        $datos = Proveedor::find($id);
        return response()->json([
            'hola' => 0,
            'Mensaje' => $datos,
        ]);
    }

   
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
            $update->nombre = $request->input('Nombre');
            $update->direccion = $request->input('Direccion');
            $update->telefono = $request->input('Telefono');
            $update->update();
            return response()->json(['Estado' => 0, 'Mensaje' => $update]);
        }
    }
   
    public function destroy($id)
    {
        $delete = Proveedor::find($id);
        $delete->delete();
        return response()->json(['Error' => 0, 'Mensaje' => 'Borrado']);
    }
    public function importar(Request $request)
    {
          try{ 
            $datos = Excel::import(new ProveedoresImport, $request->file('importar'));
      /*   dd($datos); */
             return redirect()->back()->with(['Excelente'=>'Datos subidos correctamente']); 
         }catch(Exception $e){
            return redirect()->back()->with(['Error'=>'Datos subidos correctamente']); 
            /* return $e; */
        } 
    }
}
