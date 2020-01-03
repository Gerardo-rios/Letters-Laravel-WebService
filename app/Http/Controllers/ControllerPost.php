<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerPost extends BaseController
{
    public function listar_posts(Request $request)
    {
        if ($request->isjson()){
            $posts = Post::all();
            $status = "listado";
            $info = "yalassamano";
            return ResponseBuilder::result($status, $info, $posts);     
        } else {
            return response(["msg" => "No esta enviando formato JSON", "tittle" => "error_format"], 404);
        }

    }

    public function crear_post(Request $request)
    {

    }

    
}