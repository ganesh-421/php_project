<?php

namespace App\Middlewares;

use App\Repositories\AuthRepository;

class GuestMiddleware
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
     * redirects if authenticated
     */
    public function handle()
    {
        if(!empty($this->repository->model->find($_SESSION['user_id']) ?? []))
        {
            header("Location: " . self::$redirectTo);
            exit;
        }
        return true;
    }
}