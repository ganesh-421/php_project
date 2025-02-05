<?php

use App\Core\Router;

Router::get('/', 'PageController@landing');

Router::dispatch();
