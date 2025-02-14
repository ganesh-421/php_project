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
    protected static $redirectTo =  '/dashboard';

    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * redirects if unauthenticated
     */
    public function guest()
    {
        if(count($this->repository->model->find($_SESSION['id']) ?? []));
        {
            session_destroy();
        }
    }
}