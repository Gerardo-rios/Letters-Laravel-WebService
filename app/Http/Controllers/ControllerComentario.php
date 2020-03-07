<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;
use App\Comentario;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerComentario extends BaseController
{
 
	public function comentar(Request $request){

        $Comment = new Comentario;
        $Comment->post_id = $request->postid; 
        $Comment->user_id = $request->userid;
        $Comment->contenido = $request->contenido;
        $Comment->save();
		
		return response()->json(["msg" => "el exito", "title" => "comentado"]); 

	} 

	public function listar_comentarios(Request $request){

		$respuesta = DB::select("SELECT modelo_comentario.*, modelo_user.username, modelo_user.foto_perfil from modelo_comentario,modelo_user where modelo_comentario.post_id = $request->postid and modelo_comentario.user_id = modelo_user.user_id");
		/**/
		$status = true;
		$info = "Listados";
		$data = $respuesta;
		return ResponseBuilder::result($status, $info, $data);

	}


}
