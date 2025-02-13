<?php

use App\Core\Router;

Router::get('/', 'PageController@landing');

Router::get('/login', 'AuthController@login');
Router::post('/login', 'AuthController@login');
Router::get('/register', 'AuthController@register');
Router::post('/register', 'AuthController@register');
Router::post('/logout', 'AuthController@logout');

Router::get('/dashboard', 'PageController@dashboard', 'auth');

// artists
Router::get('/artists', 'ArtistController@index', 'auth');
Router::get('/create/artist', 'ArtistController@create', 'auth');
Router::post('/create/artist', 'ArtistController@create', 'auth');
Router::post('/delete/artist', 'ArtistController@delete', 'auth');
Router::get("/update/artist", 'ArtistController@edit', 'auth');
Router::post("/update/artist", 'ArtistController@edit', 'auth');
Router::post("/export/artist", 'ArtistController@exportCsv', 'auth');
Router::post("/import/artist", 'ArtistController@importCsv', 'auth');

// musics
Router::get('/musics', 'MusicController@index', 'auth');
Router::get('/create/music', 'MusicController@create', 'auth');
Router::post('/create/music', 'MusicController@create', 'auth');
Router::post('/delete/music', 'MusicController@delete', 'auth');
Router::get("/update/music", 'MusicController@edit', 'auth');
Router::post("/update/music", 'MusicController@edit', 'auth');

// users
Router::get('/users', 'UserController@index', 'auth');
Router::get('/create/user', 'UserController@create', 'auth');
Router::post('/create/user', 'UserController@create', 'auth');
Router::post('/delete/user', 'UserController@delete', 'auth');
Router::get("/update/user", 'UserController@edit', 'auth');
Router::post("/update/user", 'UserController@edit', 'auth');

Router::dispatch();
