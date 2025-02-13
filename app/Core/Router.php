<?php

namespace App\Core;

class Router
{
    private static $routes = [];

    public static function get($uri, $controllerMethod, $middleware = null)
    {
        if($middleware ?? false)
        {
            self::middleware($middleware);
        }
        self::$routes['GET'][$uri] = $controllerMethod;
        return self::class;
    }

    public static function post($uri, $controllerMethod, $middleware = null)
    {
        if($middleware ?? false)
        {
            self::middleware($middleware);
        }
        self::$routes['POST'][$uri] = $controllerMethod;
    }

    public static function middleware($middleware)
    {
        $class = ucwords($middleware) . "Middleware";
        $class = "App\\Middlewares\\" . $class;
        $instance = new $class();
        $instance->$middleware();
    }

    public static function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        $method = $_SERVER['REQUEST_METHOD'];
        // query parameters removal
        $uri = strtok($uri, '?');

        if (isset(self::$routes[$method][$uri])) {
            $controllerMethod = explode('@', self::$routes[$method][$uri]);
            $controller = "App\\Controllers\\" . $controllerMethod[0];
            $method = $controllerMethod[1];
            $controllerInstance = new $controller();
            $controllerInstance->$method();

        } else {
            // handling of url pattern not found
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
