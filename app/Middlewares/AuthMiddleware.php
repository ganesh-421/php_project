<?php

namespace App\Middlewares;

use App\Core\Request;
use App\Models\Session;

class AuthMiddleware
{
   
    /**
     * @var private repository
     */
    // private $repository;

    /**
     * @var string redirect to
     */
    protected static $redirectTo =  '/login';

    public function __construct()
    {
        // $this->repository = new AuthRepository();
    }

    /**
     * redirects if unauthenticated
     */
    public function handle()
    {
        $session = new Session();
        if(empty($session->auth()))
        {
            if(!Request::expectJson())
            {
                if($_SERVER['REQUEST_URI'] !== self::$redirectTo)
                {
                    header("Location: " . self::$redirectTo);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode([
                    'message'=>'unauthenticated'
                ]);
                exit;
            }
        }
        return true;
    }
}