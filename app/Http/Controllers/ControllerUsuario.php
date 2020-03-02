<?php

namespace App\Http\Controllers;

use App\Usuario;

use App\Http\Controllers\Utilidades\UUID;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerUsuario extends BaseController
{

    /*public function _construct() {
        $this -> Middleware('auth', ['only' => 
            
            [
                'verPerfil'
            ]


        ]);
    }*/

    private $profilePicturesFolder = "profile_pictures";
    

    public function registrarse(Request $request)
    {

        $validar = Usuario::where("username", $request->username)->first();
    	$verificar = Usuario::where("correo", $request->correo)->first();

    	if ($validar) {
    		return response()->json(["msg" => "Ese username ya esta ocupado", "title" => "error_user"]);
    	} elseif ($verificar) {
    		return response()->json(["msg" => "Ese correo ya se ha registrado", "title" => "error_correo"]);
    	} else {
    		$usuario = new Usuario();

		    $usuario -> nombre = "";
		    $usuario -> username = $request -> username;
		    $usuario -> correo = $request -> correo;
		    $usuario -> password = Hash::make($request -> password);
		    $usuario -> descripcion = "";
		    $usuario -> foto_perfil = "https://via.placeholder.com/150x150";
		    $usuario -> celular = $request -> telefono;
            $usuario -> status = True;
            $usuario -> external_id = UUID::uuid_v4();
	           
	    	$usuario->save();


    		return response()->json(["msg" => "Registrado exitosamente", "title" => "registrado"]);
    	}

    }

    public function logearse(Request $request)
    {
        if ($request->isjson()){
            $username = $request -> username;
            $password = $request -> password;

            $user = Usuario::where('username', $username)->first();

            if (!empty($user)) {
                if (Hash::check($password, $user->password) && $user -> status) {
                    $status = true;
                    $info = "Correcto";
                    $data = $user;
                } elseif (!$user -> status) {
                    $status = false;
                    $info = "Estas baneado hasta nuevo aviso";
                    $data = "";
                }else{
                    $status = false;
                    $info = "Credenciales Incorrectas";
                    $data = "";
                }
            }else{
                $status = false;
                $info = "Credenciales Incorrectas";
                $data = "";
            }
            return ResponseBuilder::result($status, $info, $data);
            
        } else {
            return response()->json(["msg" => "No esta enviando formato JSON", "title" => "error_format"]); 
        }
    	

    }

    public function subirFotoPerfil(Request $request) 
    {
        //if ($request->isjson()) {
            if ($request->hasFile('image')) {
                $file = $request-> file('image');
                $useridenti = $request -> identificador;

                $filename = Str::random(10) . '.' .$file->getClientOriginalExtension();
        
                $user = Usuario::where('user_id', $useridenti)->first();
                $file->move($this->profilePicturesFolder,$filename);// subimos al servidor
                $user-> foto_perfil = $filename; // guardamos el nombre en la bd
                $user->save(); // guardamos los cambios.

                return response()->json(["msg" => "Foto subida exitosamente", "title" => "actualizada"]); 
            } else {
                return response()->json(["msg" => "No se esta enviado foto", "title" => "no foto"]); 
            }
            
      /*  } else {

            return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);

        }*/
        
    }

    public function ModificarDatos(Request $request){

        if ($request->isjson()){

            $identificador = $request -> identificador;

            $user = Usuario::where('user_id', $identificador)->first();;

            if ($user) {
           
                $user->nombre = $request -> nombre;
                $user->descripcion = $request -> descripcion;
                $user->save();

                return response()->json(["msg" => "Datos actualizados", "title" => "actualizado", "user" => $user]); 
            } else {
                return response()->json(["msg" => "No encontrado", "title" => "error"]); 
            }  

        } else {
            return response()->json(["msg" => "No se esta enviado formato json", "title" => "no json"]); 
        }
    } 

    public function obtenerme(Request $request){

        $user = Usuario::find($request->id);
        if ($user) {
            return response()->json(["msg" => "ok", "user" => $user]);
        } else {
            return response()->json(["msg" => "bad", "user" => ""]);
        }

    }

    
}

/* pa deshashear la passwor

	Verifying A Password Against A Hash
if (Hash::check('secret', $hashedPassword))
{
    // The passwords match...
}
Checking If A Password Needs To Be Rehashed
if (Hash::needsRehash($hashed))
{
    $hashed = Hash::make('secret');
}

*/