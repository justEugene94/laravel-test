<?php

use Illuminate\Routing\Router;

/** @var  Router $router */

/** Register */
$router->post('/register', [
    'as' => 'register',
    'uses' => 'App\Http\Controllers\Api\Auth\RegisterController@register'
]);

/** Login */
$router->post('/login', [
    'as' => 'login',
    'uses' => 'App\Http\Controllers\Api\Auth\LoginController@login'
]);

$router->group(['middleware' => [
    'auth:api',
    'throttle:20'
]], function (Router $router) {

    /** Episodes */
    $router->get('/episodes', [
        'as' => 'episodes.index',
        'uses' => 'App\Http\Controllers\Api\EpisodesController@index',
    ]);

    $router->get('/episodes/{episode_id}', [
        'as' => 'episodes.show',
        'uses' => 'App\Http\Controllers\Api\EpisodesController@show',
        'where' => [
            '{episode_id}'  => '[0-9]+',
        ],
    ]);

    /** Characters */
    $router->get('/characters', [
        'as' => 'characters.index',
        'uses' => 'App\Http\Controllers\Api\CharactersController@index',
    ]);

    $router->get('/characters/random', [
        'as' => 'characters.random',
        'uses' => 'App\Http\Controllers\Api\CharactersController@random',
    ]);

    /** Quotes */
    $router->get('/quotes', [
        'as' => 'quotes.index',
        'uses' => 'App\Http\Controllers\Api\QuotesController@index',
    ]);

    $router->get('/quotes/random', [
        'as' => 'quotes.random',
        'uses' => 'App\Http\Controllers\Api\QuotesController@random',
    ]);

});
