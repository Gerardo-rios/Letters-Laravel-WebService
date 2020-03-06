<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerPost extends BaseController
{

    //private $carpetaFotosUsuario = "fotos";

    public function listar_posts(Request $request)
    {
        if ($request->isjson()){
            $posts = Post::all();
            
            $status = true;
            $info = "Datos obtenidos con exito";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);     
        } else {
            $status = false;
            $info = "No esta enviando formato json";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        }

    }

    public function crear_post(Request $request)
    {
        if ($request->isjson()) {
            $post = new Post;
            $post->user_id = $request -> identificador;
            $post->contenido = $request-> contenido;
            $post->save();

            $status = true;
            $info = "Posteado Exitosamente";
            $data = $post;
            return ResponseBuilder::result($status, $info, $data);    
        } else {
            $status = false;
            $info = "No esta enviando formato json";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        }
        
    }

    public function posts_user_logeado(Request $request){

        $posts = Post::where('user_id', $request->identificador)->get();
        
        if ($posts) {
            $status = true;
            $info = "Listados con exito";
            $data = $posts;
            return ResponseBuilder::result($status, $info, $data);
        } else {
            $status = true;
            $info = "Nada para mostrar";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        }     

    }
    
}   