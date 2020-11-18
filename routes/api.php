<?php

use Illuminate\Routing\Router;

/** @var  Router $router */

/** Episodes */
$router->get('/episodes', [
    'as'   => 'episodes.index',
    'uses' => 'App\Http\Controllers\Api\EpisodesController@index',
]);

$router->get('/episodes/{episode_id}', [
    'as'   => 'episodes.show',
    'uses' => 'App\Http\Controllers\Api\EpisodesController@show',
]);

/** Characters */
$router->get('/characters', [
    'as' => 'characters.index',
    'uses' => 'App\Http\Controllers\Api\CharactersController@index',
]);
