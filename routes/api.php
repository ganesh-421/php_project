<?php

use App\Core\Router;

Router::post("/api/login", "AuthController@login");
Router::get("/api/musics", "MusicController@index", 'auth');
Router::post("/api/create/music", "MusicController@create", 'auth');
Router::put("/api/update/music", "MusicController@edit", 'auth');
Router::delete("/api/delete/music", "MusicController@delete", 'auth');

Router::dispatch();