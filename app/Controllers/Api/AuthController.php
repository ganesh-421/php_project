<?php

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\User;
use App\Repositories\AuthRepository;

class AuthController extends BaseApiController
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    public function login()
    {
        $rules = [
            'email' => "required|email|exists:user,email",
            'password' => 'required'
        ];
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $validator = new Validator($data, $rules, new User());

        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", $errors, 422);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->login($_POST['email'], $_POST['password']);
            if($result)
            {
                // header("Location: /dashboard");
                // exit;
            } else {
                return ;
            }
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
