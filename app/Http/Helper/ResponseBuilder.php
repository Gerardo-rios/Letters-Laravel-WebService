<?php

namespace App\Http\Helper;

class ResponseBuilder{

	public static function result($status="", $info="", $data=""){

		return response()->json([
			"success"=>$status,
			"information"=>$info,
			"data"=>$data,
		]);

	}

}