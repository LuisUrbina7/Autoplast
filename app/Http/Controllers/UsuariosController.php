<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function index()
    {
        return view('auth.update');
    }
    public function listar()
    {
        $Usuarios =  User::all();
        return view('auth.listar', compact('Usuarios'));
    }
    public function crear(Request $request)
    {
        $input = $request->all();


        if ($request->input('password') == $request->input('password_confirmation')) {
            $validator  = Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'rol' => ['required', 'string', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with($validator->errors());
            }
            User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'rol' => $input['rol'],
                'password' => Hash::make($input['password']),
            ]);
            return redirect()->back()->with('name', 'excelente');
        } else {
            return redirect()->back()->with('pares', 'Las claves no son iguales');
        }
    }
    public function actualizarPerfil(Request $request)
    {
        $user           = Auth::user();
        $userId         = $user->id;
        $userEmail      = $user->email;
        $userPassword   = $user->password;

        if ($request->input('oldpassword') != "") {
            $NuewPass   = $request->password;
            $confirPass = $request->password_confirmation;
            $name       = $request->name;
            $rol      = $request->rol;

            if (Hash::check($request->input('oldpassword'), $userPassword)) {


                if ($NuewPass == $confirPass) {

                    $update = User::find($userId);
                    $update->name = $request->input('name');
                    $update->rol = $request->input('rol');
                    $update->email = $request->input('email');
                    $update->username = $request->input('username');
                    $update->password = Hash::make($request->input('password'));
                    $update->update();

                    return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente.');
                } else {
                    return redirect()->back()->with('pares', 'Las claves no son iguales');
                }
            } else {
                return back()->withErrors(['oldpassword' => 'La Clave no Coinciden']);
            }
        } else {
            $update = User::find($userId);
            $update->name = $request->input('name');
            $update->email = $request->input('email');
            $update->username = $request->input('username');
            if ($request->input('rol') != null) {
                $update->rol = $request->input('rol');
            }

            $update->update();

            return redirect()->back()->with('name', 'El nombre fue cambiado correctamente.');;
        }
    }
    public function actualizar(Request $request)
    {
        $user           = User::find($request->input('id'));


        if ($request->input('password') != "") {
            $NuewPass   = $request->password;
            $confirPass = $request->password_confirmation;

            if ($NuewPass == $confirPass) {


                $user->name = $request->input('name');
                $user->rol = $request->input('rol');
                $user->email = $request->input('email');
                $user->username = $request->input('username');
                $user->password = Hash::make($request->input('password'));
                $user->update();

                return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente.');
            } else {
                return redirect()->back()->with('pares', 'Las claves no son iguales');
            }
        } else {

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->username = $request->input('username');
            if ($request->input('rol') != null) {
                $user->rol = $request->input('rol');
            }

            $user->update();

            return redirect()->back()->with('name', 'El nombre fue cambiado correctamente.');;
        }
    }
    public function borrar($id)
    {
        $dato = User::find($id);
       if ($dato->delete()!=null) {
           return redirect()->back()->with('success','Borrado Correctamente');
       
           $dato->delete();
       } else {
        return redirect()->back()->with('error','Error en el borrado.');
       }
    }
}
