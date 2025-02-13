<?php

namespace App\Middlewares;

use App\Repositories\AuthRepository;

class AuthMiddleware
{
   
    /**
     * @var private repository
     */
    private $repository;

    /**
     * @var string redirect to
     */
    protected static $redirectTo =  '/login';

    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * redirects if unauthenticated
     */
    public function handle()
    {
        if(empty($this->repository->model->find($_SESSION['user_id']) ?? []))
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