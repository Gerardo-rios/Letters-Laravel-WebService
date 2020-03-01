<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;
use App\Likes;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerLike extends BaseController
{
 
	public function dar_like(Request $request){

        $validar = DB::select("SELECT * FROM modelo_likes WHERE post_id_id = $request->postid AND user_id_id = $request->userid"); 

		if ($validar) {
			
			return response()->json(["msg" => "yasta", "title" => "like"]); 

		} else {

			$Like = new Likes;
        	$Like->post_id_id = $request->postid; 
        	$Like->user_id_id = $request->userid;
        	$Like->save();
		
			return response()->json(["msg" => "el exito", "title" => "like"]); 
		}

	} 

	public function contar_likes(Request $request){

		$contar = DB::select("SELECT count(post_id_id) as likes FROM modelo_likes WHERE post_id_id = $request->postid");

		 return response()->json($contar); 

	}

	public function quitar_like(Request $request){

		$borrar = DB::delete("DELETE FROM modelo_likes WHERE post_id_id = $request->postid AND user_id_id = $request->userid");


		return response()->json($borrar); 
	}



}
