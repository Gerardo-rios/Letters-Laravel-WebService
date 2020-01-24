<?php 

namespace App\Http\Controllers\Utilidades;

class UUID {
	public static function uuid_v4(){
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 

		 		mt_rand(0, 0xffff), mt_rand(0, 0xffff),

		 		mt_rand(0, 0xffff),

		 		mt_rand(0, 0xffff) | 0x4000,

		 		mt_rand(0, 0x3fff) | 0x8000,

		 	 	mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		 	 );
	}
}