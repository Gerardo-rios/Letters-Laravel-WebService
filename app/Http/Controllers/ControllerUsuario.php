<?php

namespace App\Http\Controllers;

use App\Usuario;

use App\Http\Controllers\Utilidades\UUID;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerUsuario extends BaseController
{

    private $profilePicturesFolder = "profile_pictures";
    

    public function registrarse(Request $request)
    {
        if ($request->isjson()) {
            $validar = Usuario::where("username", $request->username)->first();
            $verificar = Usuario::where("correo", $request->correo)->first();

            if ($validar) {
                return response()->json(["msg" => "Ese username ya esta ocupado", "title" => "error_user"]);
            } elseif ($verificar) {
                return response()->json(["msg" => "Ese correo ya se ha registrado", "title" => "error_correo"]);
            } else {
                $usuario = new Usuario();

                $usuario -> nombre = Str::random(10);
                $usuario -> username = $request -> username;
                $usuario -> correo = $request -> correo;
                $usuario -> password = Hash::make($request -> password);
                $usuario -> descripcion = "";
                $usuario -> foto_perfil = "/profile_pictures/default_user.png";
                $usuario -> celular = $request -> telefono;
                $usuario -> status = True;
                $usuario -> external_id = UUID::uuid_v4();
               
                $usuario->save();


                return response()->json(["msg" => "Registrado exitosamente", "title" => "registrado"]);
            }   
        } else {
            return response()->json(["msg" => "No esta enviando formato json", "title" => "error_format"]);
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
        $ide = $request -> id;
        $foto = $request -> foto;
        $host = $request -> hos;
        $user = Usuario::where('user_id', $ide)->first();
        if ($user) {
            
            $path = "profile_pictures/$user->username.jpg";
            file_put_contents($path, base64_decode($foto));
            $bytesArchivo = file_get_contents($path);

            $url = $host . '/' . $path;
            $user->foto_perfil = '/' . '' . $path;
            $user->save();

            return response()->json(["msg" => "Actualizada", "title" => "OK"]);

        } else {

            return response()->json(["msg" => "No actualizada", "title" => "ERROR"]);

        }
        
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
            $status = true;
            $info = "Obtenido";
            $data = $user;
            return ResponseBuilder::result($status, $info, $data);
        } else {
            $status = false;
            $info = "no obtenido";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        }

    }

    public function conteo(Request $request){

        $contar_seguidores = DB::select("SELECT count(seguidor_id) as numero_seguidores FROM modelo_seguidores WHERE seguido_id = $request->authid");

        $contar_seguidos = DB::select("SELECT count(seguido_id) as numero_seguidos FROM modelo_seguidores WHERE seguidor_id = $request->authid");

        return response()->json(["seguidores" => $contar_seguidores, "seguidos" => $contar_seguidos]);

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