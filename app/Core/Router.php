<?php

namespace App\Core;

use App\Core\Exceptions\RouteNotFoundException;
use BadMethodCallException;

class Router
{
    private static $routes = [];

    /**
     * handles get request
     */
    public static function get(string $uri, string $controllerMethod, string $middleware = null): void
    {
        self::$routes['GET'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles post request
     */
    public static function post(string $uri, string $controllerMethod, string $middleware = null): void
    {
        self::$routes['POST'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles patch request
     */
    public static function patch(string $uri, string $controllerMethod, string $middleware = null): void
    {
        self::$routes['PATCH'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles put request
     */
    public static function put(string $uri, string $controllerMethod, string $middleware = null): void
    {
        self::$routes['PUT'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles delete request
     */
    public static function delete(string $uri, string $controllerMethod, string $middleware = null): void
    {
        self::$routes['DELETE'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
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
            if(!method_exists($controller, $method))
            {
                throw new BadMethodCallException("Method " . $method . " Doesn't Exists Controller " . $controller);
            }
            $controllerInstance = new $controller();
            $controllerInstance->$method();

        } else {
            // // handling of url pattern not found
            // http_response_code(404);
            // echo "404 Not Found";
            throw new RouteNotFoundException();
        }
    }
}
