<?php

use App\Core\Router;

Router::post("/api/login", "AuthController@login");

Router::dispatch();