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
Router::post('/delete/artist', 'ArtistController@delete');
Router::get("/update/artist", 'ArtistController@edit');
Router::post("/update/artist", 'ArtistController@edit');

// musics
Router::get('/musics', 'MusicController@index');
Router::get('/create/music', 'MusicController@create');
Router::post('/create/music', 'MusicController@create');
Router::post('/delete/music', 'MusicController@delete');
Router::get("/update/music", 'MusicController@edit');
Router::post("/update/music", 'MusicController@edit');

Router::dispatch();
