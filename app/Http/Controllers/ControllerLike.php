<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Post;
use App\Likes;

use App\Http\Helper\ResponseBuilder;

use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerLike extends BaseController
{
 
	public function dar_like(Request $request){

        $postid = $request-> postid;
        $userid = $request -> userid;
        $Like = new Likes;
        $Like->post_id_id = $postid; 
        $Like->user_id_id = $userid;
        $Like->save();

        return response()->json(["msg" => "el exito", "title" => "like"]); 

	} 

}
