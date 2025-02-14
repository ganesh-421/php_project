<?php

namespace App\Middlewares;

use App\Models\Session;
use App\Repositories\AuthRepository;

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
            if($_SERVER['REQUEST_URI'] !== self::$redirectTo)
            {
                header("Location: " . self::$redirectTo);
                exit;
            }
        }
        return true;
    }
}