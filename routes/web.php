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

	/*$router->get('/all', 'ControladorCliente@index');

	$router->get('/get/{cedula}', 'ControladorCliente@getCliente');

	$router->get('/obt/{apellido}', 'ControladorCliente@getClienteApe');

	$router->post('/create', 'ControladorCliente@createCliente');

	$router->put('/modi/{cedula}', 'ControladorCliente@putCliente');*/

});

$router->group(['prefix'=>'/posts'], function($router){

	$router->get('/', 'ControllerPost@listar_posts');

});

