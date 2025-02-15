<?php

use App\Core\Router;

Router::post("/api/login", "AuthController@login");
Router::post("/api/musics", "MusicController@index", 'auth');

Router::dispatch();