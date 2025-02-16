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
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->register($data);
        if($result) {
            return $this->sendSuccess([], "User Registered Succesfully");
        } else {
            return $this->sendError("User Couldn't Be Registered");
        }
    }

    public function logout()
    {
        $this->repository->logout();
        return $this->sendSuccess([], "User Logged Out Succesfully");
    }
}
