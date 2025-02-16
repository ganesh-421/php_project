<?php

use App\Core\Router;

// Auth
Router::post("/api/login", "AuthController@login");
Router::post("/api/register", "AuthController@register");
Router::post("/api/logout", "AuthController@logout");
// User
Router::get("/api/users", "UserController@index", 'auth');
Router::post("/api/create/user", "UserController@create", 'auth');
Router::put("/api/update/user", "UserController@edit", 'auth');
Router::delete("/api/delete/user", "UserController@delete", 'auth');
// Artist
Router::get("/api/artists", "ArtistController@index", 'auth');
Router::post("/api/create/artist", "ArtistController@create", 'auth');
Router::put("/api/update/artist", "ArtistController@edit", 'auth');
Router::delete("/api/delete/artist", "ArtistController@delete", 'auth');
// Music
Router::get("/api/musics", "MusicController@index", 'auth');
Router::post("/api/create/music", "MusicController@create", 'auth');
Router::put("/api/update/music", "MusicController@edit", 'auth');
Router::delete("/api/delete/music", "MusicController@delete", 'auth');

Router::dispatch();