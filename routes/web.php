<?php

use App\Core\Router;

Router::get('/', 'PageController@landing');

Router::get('/login', 'AuthController@login');
Router::post('/login', 'AuthController@login');
Router::get('/register', 'AuthController@register');
Router::post('/register', 'AuthController@register');
Router::post('/logout', 'AuthController@logout');


Router::get('/dashboard', 'PageController@dashboard')->middleware('auth');

// artists
Router::get('/artists', 'ArtistController@index');
Router::get('/create/artist', 'ArtistController@create');
Router::post('/create/artist', 'ArtistController@create');
Router::post('/delete/artist', 'ArtistController@delete');
Router::get("/update/artist", 'ArtistController@edit');
Router::post("/update/artist", 'ArtistController@edit');
Router::post("/export/artist", 'ArtistController@exportCsv');
Router::post("/import/artist", 'ArtistController@importCsv');

// musics
Router::get('/musics', 'MusicController@index');
Router::get('/create/music', 'MusicController@create');
Router::post('/create/music', 'MusicController@create');
Router::post('/delete/music', 'MusicController@delete');
Router::get("/update/music", 'MusicController@edit');
Router::post("/update/music", 'MusicController@edit');

// users
Router::get('/users', 'UserController@index');
Router::get('/create/user', 'UserController@create');
Router::post('/create/user', 'UserController@create');
Router::post('/delete/user', 'UserController@delete');
Router::get("/update/user", 'UserController@edit');
Router::post("/update/user", 'UserController@edit');

Router::dispatch();
