<?php
session_start();
// psr-4 autoloader
require_once __DIR__ . '/../app/Core/Autoloader.php';

// routes
require_once __DIR__ . '/../routes/web.php';

// request dispatch
\App\Core\Router::dispatch();