<?php

namespace App\Controllers;

use App\Core\Validator;
use App\Models\User;
use App\Repositories\AuthRepository;

class AuthController
{
    private $repository;
    /**
     * instantiate auth controller
     */
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * logs the user into system (post), login form (get)
     */
    public function login()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $_SESSION['errors'] = $errors;
                header("Location: /login");
                exit;
            }
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
            exit;
        }
    }

    /**
     * register new user (post), register form (get)
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rules = [
                "first_name" => 'required|min:3|max:255',
                "last_name" => 'required|min:3|max:255',
                "email" => 'required|email|unique:user,email',
                "password" => 'required|min:8|max:15',
                "phone" => 'required|min:10|max:10|unique:user,phone',
                "dob" => 'required|before:today',
                "gender" => 'required|in:m,f,o',
                "address" => 'required|min:3|max:255',
                "role" => 'required|in:super_admin,admin,artist',
            ];
            $data = [
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "password" => $_POST['password'],
                "phone" => $_POST['phone'],
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                "role" => $_POST['role'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $validator = new Validator($data, $rules, (new User()));
            if(!$validator->validate()) {
                $errors = $validator->errors();
                $_SESSION['errors'] = $errors;
                header("Location: /register");
                exit;
            }
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
            exit;
        }
    }

    /**
     * logs out the user
     */
    public function logout()
    {
        $this->repository->logout();
        header("Location: /login");
        exit;
    }
}
