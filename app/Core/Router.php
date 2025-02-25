<?php

namespace App\Core;

use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Ratelimits\RateLimiter;
use BadMethodCallException;
use Exception;

class Router
{
    /**
     * @param array web routes with controller methods and middleware
     */
    private static $routes = [];

    /**
     * @param array api routes with controller methods and middleware 
     */
    private static $apiRoutes = [];

    /**
     * handles get request
     */
    public static function get(string $uri, string $controllerMethod, string $middleware = null): void
    {
        if(Request::expectJson())
            self::$apiRoutes['GET'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
        else 
            self::$routes['GET'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles post request
     */
    public static function post(string $uri, string $controllerMethod, string $middleware = null): void
    {
        if(Request::expectJson())
            self::$apiRoutes['POST'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
        else
            self::$routes['POST'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles patch request
     */
    public static function patch(string $uri, string $controllerMethod, string $middleware = null): void
    {
        if(Request::expectJson())
            self::$apiRoutes['PATCH'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
        else
            self::$routes['PATCH'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles put request
     */
    public static function put(string $uri, string $controllerMethod, string $middleware = null): void
    {
        if(Request::expectJson())
            self::$apiRoutes['PUT'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
        else
            self::$routes['PUT'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * handles delete request
     */
    public static function delete(string $uri, string $controllerMethod, string $middleware = null): void
    {
        if(Request::expectJson())
            self::$apiRoutes['DELETE'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
        else
            self::$routes['DELETE'][$uri] = ['controller' => $controllerMethod, 'middleware' => $middleware];
    }

    /**
     * dispatch respective routes according to request
     */
    public static function dispatch()
    {
        $limiter = new RateLimiter();

        if(!$limiter->isAllowed())
        {
            if(Request::expectJson())
            {
                header('Content-Type: application/json');
                http_response_code(429);
                echo json_encode([
                    'success' => false,
                    'message' => "Too Many Requests"
                ]);
                exit;
            } else {
                http_response_code(429);
                $_SESSION['error'] = "Too Many Requests";
                exit;
            }
        }

        if(Request::expectJson())
            self::dispatchRoute(static::$apiRoutes);
        else 
            self::dispatchRoute(self::$routes);
    }

    /**
     * dispatch the routes given
     * @param array routes
     */
    private static function dispatchRoute($routes)
    {
        try {
            $uri = $_SERVER['REQUEST_URI'];
            
            $method = $_SERVER['REQUEST_METHOD'];
            // query parameters removal
            $uri = strtok($uri, '?');
            
            if (isset($routes[$method][$uri])) {
                $route = $routes[$method][$uri];
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
                $controller = Request::expectJson() ? "App\\Controllers\\Api\\" . $controllerMethod[0] : "App\\Controllers\\" . $controllerMethod[0];
                $method = $controllerMethod[1];
                if(!method_exists($controller, $method))
                {
                    throw new BadMethodCallException("Method " . $method . " Doesn't Exists Controller " . $controller);
                }
                $controllerInstance = new $controller();
                $controllerInstance->$method();
    
            } else {
                throw new RouteNotFoundException();
            }
        } catch(Exception $e)
        {
            if(Request::expectJson())
            {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }
    }
}
