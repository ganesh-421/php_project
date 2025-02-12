<?php

namespace App\Middlewares;

use App\Repositories\AuthRepository;

class AuthMiddleware
{
   
    /**
     * @var private repository
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * redirects if unauthenticated
     */
    public function auth()
    {
        
    }
}