<?php

use Illuminate\Routing\Router;

/** @var  Router $router */

/** Episodes */
$router->get('/episodes', [
    'as'   => 'episodes',
    'uses' => 'App\Http\Controllers\Api\EpisodesController@index',
]);
