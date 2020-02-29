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


	/*$router->get('/all', 'ControladorCliente@index');

	$router->get('/get/{cedula}', 'ControladorCliente@getCliente');

	$router->get('/obt/{apellido}', 'ControladorCliente@getClienteApe');

	$router->post('/create', 'ControladorCliente@createCliente');

	$router->put('/modi/{cedula}', 'ControladorCliente@putCliente');*/

});	

$router->group(['prefix'=>'/posts'], function($router){

	$router->get('/listar_todos', 'ControllerPost@listar_posts');

	$router->get('/listar_user_posts/{identificador}', 'ControllerPost@posts_user_logeado');	

	$router->post('/postear', 'ControllerPost@crear_post');

});


$router->group(['prefix'=>'/like'], function($router){

	$router->post('/', 'ControllerLike@dar_like');

});
