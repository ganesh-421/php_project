<?php

// psr-4 autoloader
require __DIR__ . '/../app/Core/Autoloader.php';

// routes
require __DIR__ . '/../routes/web.php';

// request dispatch
\App\Core\Router::dispatch();