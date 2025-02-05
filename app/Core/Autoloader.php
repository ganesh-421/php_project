<?php

namespace App\Core;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $prefix = 'App\\';
            $base_dir = __DIR__ . '/../';

            if (strpos($class, $prefix) === 0) {
                $relative_class = substr($class, strlen($prefix));
                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                }
            }
        });
    }
}

Autoloader::register();
