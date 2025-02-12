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
    protected $redirectTo;

    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * redirects if unauthenticated
     */
    public function auth()
    {
        if(count($this->repository->model->find($_SESSION['id'])))
        {
            header("Locations: " . static::$redirectTo);
        }
    }
}