<?php

use App\Core\Request;

session_start();
// psr-4 autoloader
require_once __DIR__ . '/../app/Core/Autoloader.php';

// routes
if(!Request::expectJson()) 
{
    require_once __DIR__ . '/../routes/web.php';
}
else {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,PATCH");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once __DIR__ . '/../routes/api.php';
}
