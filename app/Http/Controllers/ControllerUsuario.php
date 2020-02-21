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
    	if ($request->isjson()){

    		$validar = Usuario::where("username", $request->username)->first();
    		$verificar = Usuario::where("correo", $request->correo)->first();

    		if ($validar) {
    			return response(["msg" => "Ese username ya esta ocupado", "title" => "error_user"], 404);
    		} elseif ($verificar) {
    			return response(["msg" => "Ese correo ya se ha registrado", "title" => "error_correo"], 404);
    		} else {
    			$usuario = new Usuario();

		    	$usuario -> nombre = $request -> nombre;
		    	$usuario -> username = $request -> username;
		    	$usuario -> fecha_nacimiento = $request -> fecha_nacimiento;
		    	$usuario -> correo = $request -> correo;
		    	$usuario -> password = Hash::make($request -> password);
		    	$usuario -> descripcion = "";
		    	$usuario -> foto_perfil = "https://via.placeholder.com/150x150";
		    	$usuario -> celular = "";
                $usuario -> status = True;
                $usuario -> external_id = UUID::uuid_v4();
	            
	    		$usuario->save();

    			return response()->json(["msg" => "Registrado exitosamente", "title" => "registrado"], 200);
    		}
    		
    	} else {

    		return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);

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
            return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);
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

                return response()->json(["msg" => "Foto subida exitosamente", "title" => "actualizada"], 200); 
            } else {
                return response()->json(["msg" => "No se esta enviado foto", "title" => "no foto"], 404); 
            }
            
      /*  } else {

            return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);

        }*/
        
    }

    public function ModificarDatos(Request $request){

        if ($request->isjson()){

        $identificador = $request -> identificador;

        $user = Usuario::where('user_id', $identificador)->first();;

        $user->nombre = $request-> input('nombre');
        $user->descripcion = $request-> input('descripcion');
        $user->celular = $request-> input('celular');
        $user->save();

        return response(["msg" => "Datos actualizados", "tittle" => "Modificado"], 200);

        } else {
            return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);
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