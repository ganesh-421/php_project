<?php

namespace App\Core;

class Router
{
    private static $routes = [];

    public static function get($uri, $controllerMethod, $middleware = null)
    {
        // if($middleware ?? false)
        // {
        //     self::middleware($middleware);
        // }
        // self::$routes['GET'][$uri] = $controllerMethod;
        // return self::class;


        self::$routes['GET'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    public static function post($uri, $controllerMethod, $middleware = null)
    {
        // if($middleware ?? false)
        // {
        //     self::middleware($middleware);
        // }
        // self::$routes['POST'][$uri] = $controllerMethod;
        self::$routes['POST'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
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
            $route = self::$routes[$method][$uri];

            if (!empty($route['middleware'])) {
                $middlewareClass = "App\\Middlewares\\" . ucfirst($route['middleware']) . "Middleware";
                if (class_exists($middlewareClass)) {
                    $middlewareInstance = new $middlewareClass();
                    if (!$middlewareInstance->handle()) {
                        return;
                    }
                }
            }

            $controllerMethod = explode('@', $route['controller']);
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
