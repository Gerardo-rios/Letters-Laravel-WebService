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

    private $carpetaFotosUsuario = "fotos";

    public function listar_posts(Request $request)
    {
        if ($request->isjson()){
            $posts = Post::all();
            
            return response()->json($posts, 200);     
        } else {
            return response()->json(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"]);
        }

    }

    public function crear_post(Request $request)
    {
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $description = $request-> descripcion;
            $filename = Str::random(10) . '.' .$file->getClientOriginalExtension();
        
            $useridenti = $request -> identificador;
            $post = new Post;
            $file->move($this->carpetaFotosUsuario, $filename);
        
            $post->user_id = $useridenti; 
            $post->contenido = $filename;
            $post->descripcion = $description;
            $post->etiquetas = ""; 
            $post->save();

            return response()->json(["msg" => "el exito", "title" => "subido"]); 

        } else {
            return response()->json(["msg" => "No se esta enviado foto", "title" => "no foto"]); 
        }
    }

    public function posts_user_logeado(Request $request, $identificador){

        if ($request->isjson()){
            $posts = Post::where('user_id', $identificador)->get();
            
            return response()->json($posts);     
        } else {
            return response()->json(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"]);
        }

    }

    
}