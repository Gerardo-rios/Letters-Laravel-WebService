<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;
use App\Seguidores;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerSeguidores extends BaseController
{
 
	public function seguir(Request $request){

		$validar = DB::select("SELECT * FROM modelo_seguidores WHERE seguido_id = $request->perfid AND seguidor_id = $request->authid");

		if ($validar) {
		 	return response()->json(["msg" => "yasta", "title" => "Seguiendo"]); 
		} else {
			if ($request->perfid == $request->authid) {
				return response()->json(["msg" => "yomero", "title" => "No te sigas tu mismo"]); 
			} else {
				$Seguir = new Seguidores;
        		$Seguir->seguido_id = $request->perfid; 
        		$Seguir->seguidor_id = $request->authid;
        		$Seguir->aceptado = True;
        		$Seguir->save();	
				return response()->json(["msg" => "Exito", "title" => "Seguido"]); 
			}
		}

	} 

	public function listar_seguidos(Request $request){

		$seguidos = DB::select("SELECT seguido_id as seguidos FROM modelo_seguidores WHERE seguidor_id = $request->authid");

		return response()->json($seguidos);

	}

	public function listar_seguidores(Request $request){

		$seguidos = DB::select("SELECT seguidor_id as seguidores FROM modelo_seguidores WHERE seguido_id = $request->authid");

		return response()->json($seguidos);

	}

	public function contar_seguidores(Request $request){

		$contar = DB::select("SELECT count(seguidor_id) as numero_seguidores FROM modelo_seguidores WHERE seguido_id = $request->authid");

		return response()->json($contar);
	}

}
