<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api/v1', 'namespace' => 'V1'], function () use ($router) {
    $router->group(['prefix' => '/authors'], function () use ($router) {
        $router->get('/', [
            'uses' => 'AuthorController@findAll',
        ]);

        $router->get('/{id}', [
            'uses' => 'AuthorController@findOne',
        ]);

        $router->post('/', [
            'uses' => 'AuthorController@create',
        ]);

        $router->put('/{id}', [
            'uses' => 'AuthorController@update',
        ]);

        $router->patch('/{id}', [
            'uses' => 'AuthorController@update',
        ]);

        $router->delete('/{id}', [
            'uses' => 'AuthorController@delete',
        ]);
    });
});
