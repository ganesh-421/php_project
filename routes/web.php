<?php

use App\Core\Router;

// Router::get('/', 'PageController@landing');

Router::get('/login', 'PageController@login');
Router::get('/register', 'PageController@register');
Router::post('/register', 'PageController@register');
Router::post('/login', 'PageController@login');
Router::get('/dashboard', 'PageController@dashboard');
Router::post('/logout', 'SessionController@destroy');

Router::dispatch();
