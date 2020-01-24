<?php

namespace App\Http\Controllers;

use App\Usuario;

use App\Http\Controllers\Utilidades\UUID;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerUsuario extends BaseController
{

    public function _construct() {
        $this -> Middleware('auth', ['only' => 
            
            [
                'verPerfil'
            ]


        ]);
    }

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
                    $info = "Estas baneado por tonto";
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

    public function verPerfil(Request $request){

        return response("hola");

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