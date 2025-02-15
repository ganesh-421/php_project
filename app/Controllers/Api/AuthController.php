<?php

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\User;
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
        $rules = [
            'email' => "required|exists:user,email",
            'password' => 'required'
        ];
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $validator = new Validator($data, $rules, new User());

        if(!$validator->validate()) {
            $errors = json_encode($validator->errors());
            var_dump($errors);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->login($_POST['email'], $_POST['password']);
            // if($result)
            // {
            //     header("Location: /dashboard");
            //     exit;
            // } else {
            //     $_SESSION['error'] = "Invalid Credentials";
            //     header("Location: /login");
            //     exit;
            // }
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
