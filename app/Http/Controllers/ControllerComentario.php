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

		$respuesta = Comentario::where('post_id', $request->postid)->get();

		return response()->json($respuesta);

	}

}
