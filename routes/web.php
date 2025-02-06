<?php

use App\Core\Router;

Router::get('/', 'PageController@landing');

Router::get('/login', 'AuthController@login');
Router::post('/login', 'AuthController@login');
Router::get('/register', 'AuthController@register');
Router::post('/register', 'AuthController@register');
Router::post('/logout', 'AuthController@logout');

Router::get('/dashboard', 'PageController@dashboard');

// artists
Router::get('/artists', 'ArtistController@index');
Router::get('/create/artist', 'ArtistController@create');
Router::post('/create/artist', 'ArtistController@create');

Router::dispatch();
