<?php

namespace App\Controllers;

use App\Repositories\AuthRepository;

class AuthController
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->login($_POST['email'], $_POST['password']);
            if($result)
            {
                header("Location: /dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Invalid Credentials";
                header("Location: /login");
                exit;
            }
        } else {
            require_once __DIR__ . '/../Views/front/login.php';
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->register($_POST);
            if($result) {
                $_SESSION['success'] = "Succesfully registered";
                header("Location: /login");
                exit;
            } else {
                header("Location: /register");
                exit;
            }
        } else {
            require_once __DIR__ . '/../Views/front/register.php';
        }
    }

    public function logout()
    {
        $this->repository->logout($_POST['email'], $_POST['password']);
        header("Location: /login");
    }
}
