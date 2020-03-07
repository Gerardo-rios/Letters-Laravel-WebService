<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerPost extends BaseController
{

    //private $carpetaFotosUsuario = "fotos";

    public function listar_posts(Request $request)
    {

        $posts = DB::select("SELECT modelo_post.post_id, modelo_post.contenido, modelo_post.created_at, modelo_post.user_id, modelo_user.username, modelo_user.foto_perfil FROM modelo_post, modelo_user WHERE modelo_post.user_id = modelo_user.user_id ORDER BY modelo_post.created_at DESC");
        
        $status = true;
        $info = "Datos obtenidos con exito";
        $data = $posts;
        return ResponseBuilder::result($status, $info, $data);     

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


    public function contar_likes_coments(Request $request){

        $contar_likes = DB::select("SELECT count(post_id_id) as likes FROM modelo_likes WHERE post_id_id = $request->postid");

        $contar_coments = DB::select("SELECT count(coment_id) as comentarios FROM modelo_comentario WHERE post_id = $request->postid");

        return response()->json(["like" => $contar_likes, "coment" => $contar_coments]);

    }

    public function borrar_poste(Request $request){


        $userid = $request -> authid;
        $post = Post::where("post_id", $request->postid)->first();

        if ($userid == $post->user_id) {
            $post->delete();
            $status = true;
            $info = "Se ha eliminado Exitosamente";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        } else {
            $status = false;
            $info = "No puedes borrar un post que no te pertenece";
            $data = "";
            return ResponseBuilder::result($status, $info, $data);
        }
    }
    
}   