<?php

use App\Core\Router;

// Router::get('/', 'PageController@landing');

Router::get('/', 'PageController@login');
Router::get('/register', 'PageController@register');

Router::dispatch();
