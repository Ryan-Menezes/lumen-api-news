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

    $router->group(['prefix' => '/notices'], function () use ($router) {
        $router->get('/', [
            'uses' => 'NoticeController@findAll',
        ]);

        $router->get('/{id}', [
            'uses' => 'NoticeController@findOne',
        ]);

        $router->get('/slug/{slug}', [
            'uses' => 'NoticeController@findBySlug',
        ]);

        $router->get('/author/{author}', [
            'uses' => 'NoticeController@findByAuthor',
        ]);

        $router->post('/', [
            'uses' => 'NoticeController@create',
        ]);

        $router->put('/{id}', [
            'uses' => 'NoticeController@update',
        ]);

        $router->patch('/{id}', [
            'uses' => 'NoticeController@update',
        ]);

        $router->delete('/{id}', [
            'uses' => 'NoticeController@delete',
        ]);

        $router->delete('/slug/{slug}', [
            'uses' => 'NoticeController@deleteBySlug',
        ]);

        $router->delete('/author/{author}', [
            'uses' => 'NoticeController@deleteByAuthor',
        ]);
    });

    $router->group(['prefix' => '/notices-images'], function () use ($router) {
        $router->get('/', [
            'uses' => 'NoticeImageController@findAll',
        ]);

        $router->get('/{id}', [
            'uses' => 'NoticeImageController@findOne',
        ]);

        $router->get('/notice/{notice}', [
            'uses' => 'NoticeImageController@findByNotice',
        ]);

        $router->post('/', [
            'uses' => 'NoticeImageController@create',
        ]);

        $router->put('/{id}', [
            'uses' => 'NoticeImageController@update',
        ]);

        $router->patch('/{id}', [
            'uses' => 'NoticeImageController@update',
        ]);

        $router->delete('/{id}', [
            'uses' => 'NoticeImageController@delete',
        ]);

        $router->delete('/notice/{notice}', [
            'uses' => 'NoticeImageController@deleteByNotice',
        ]);
    });
});
