<?php

use Illuminate\Routing\Router;

/** @var  Router $router */

/** Episodes */
$router->get('/episodes', [
    'as'   => 'episodes.index',
    'uses' => 'App\Http\Controllers\Api\EpisodesController@index',
]);

/** Episodes */
$router->get('/episodes/{episode_id}', [
    'as'   => 'episodes.show',
    'uses' => 'App\Http\Controllers\Api\EpisodesController@show',
]);
