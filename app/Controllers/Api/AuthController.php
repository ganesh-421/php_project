<?php

namespace App\Controllers\Api;

use App\Core\Config;
use App\Core\Jwt\Jwt;
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

    /**
     * logs user into the system after verifying credentials
     */
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
            return $this->sendError("Validation Error", 422, $errors);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $this->repository->login($_POST['email'], $_POST['password']);
            if($user_id)
            {
                $token = $this->repository->model->createToken($user_id);
                $this->sendSuccess(['token' => $token], "Succesfully Logged In");
            } else {
                $this->sendError("Authentication Failed");
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
