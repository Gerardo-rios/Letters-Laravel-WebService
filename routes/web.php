<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'/usuario'], function($router){

	$router->post('/registrar', 'ControllerUsuario@registrarse');

	$router->post('/logear', 'ControllerUsuario@logearse');

	$router->post('/actualizar_foto', 'ControllerUsuario@subirFotoPerfil');

	$router->post('/modificar_perfil', 'ControllerUsuario@ModificarDatos');

	$router->get('/contar', 'ControllerUsuario@conteo');
});	

$router->group(['prefix'=>'/post'], function($router){

	$router->get('/listar_todos', 'ControllerPost@listar_posts');

	$router->get('/listar_user_posts', 'ControllerPost@posts_user_logeado');	

	$router->post('/postear', 'ControllerPost@crear_post');

});


$router->group(['prefix'=>'/like'], function($router){

	$router->post('/', 'ControllerLike@dar_like');

	$router->get('/contar', 'ControllerLike@contar_likes');

	$router->post('/quitar', 'ControllerLike@quitar_like');

});

$router->group(['prefix'=>'/comentar'], function($router){

	$router->post('/', 'ControllerComentario@comentar');

	$router->get('/listar', 'ControllerComentario@listar_comentarios');
	
});

$router->group(['prefix'=>'/seguir'], function($router){

	$router->post('/', 'ControllerSeguidores@seguir');

	$router->get('/listar_seguidos', 'ControllerSeguidores@listar_seguidos');

	$router->get('/listar_seguidores', 'ControllerSeguidores@listar_seguidores');

	#$router->get('/contar_seguidores', 'ControllerSeguidores@contar_seguidores');

	#$router->get('/contar_seguidos', 'ControllerSeguidores@contar_seguidos');
	
});

$router->get('/obtener', 'ControllerUsuario@obtenerme');



/*$router->get('/post/{id}', ['middleware' => 'auth', function (Request $request, $id) {
    $user = Auth::user();

    $user = $request->user();

}]);*/
