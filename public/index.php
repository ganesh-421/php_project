<?php

use App\Core\Request;

session_start();
// psr-4 autoloader
require_once __DIR__ . '/../app/Core/Autoloader.php';

// routes
if(!Request::expectJson()) 
    require_once __DIR__ . '/../routes/web.php';
else
    require_once __DIR__ . '/../routes/api.php';
