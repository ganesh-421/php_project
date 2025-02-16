<?php

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\User;
use App\Repositories\AuthRepository;

class AuthController extends BaseApiController
{
    /**
     * @var \\App\\Repositories\\AuthRepository
     */
    private $repository;

    /**
     * instantiate auth controller
     */
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * validate and logs user into the system after verifying credentials
     */
    public function login()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $rules = [
            'email' => "required|email|exists:user,email",
            'password' => 'required'
        ];
        $data = [
            'email' => $post_vars['email'],
            'password' => $post_vars['password']
        ];

        $validator = new Validator($data, $rules, new User());

        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }

        $user_id = $this->repository->login($post_vars['email'], $post_vars['password']);
        if($user_id)
        {
            $token = $this->repository->model->createToken($user_id);
            $this->sendSuccess(['token' => $token], "Succesfully Logged In");
        } else {
            $this->sendError("Authentication Failed");
        }
    }

    /**
     * validate and register new user
     */
    public function register()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $rules = [
            "first_name" => 'required|min:3|max:255',
            "last_name" => 'required|min:3|max:255',
            "email" => 'required|email|unique:user,email',
            "password" => 'required|min:8|max:15',
            "phone" => 'required|min:10|max:10|unique:user,phone',
            "dob" => 'required|before:today',
            "gender" => 'required|in:m,f,o',
            "address" => 'required|min:3|max:255',
            "role" => 'required|in:super_admin,artist_manager,artist',
        ];
        $data = [
            "first_name" => $post_vars['first_name'],
            "last_name" => $post_vars['last_name'],
            "email" => $post_vars['email'],
            "password" => $post_vars['password'],
            "phone" => $post_vars['phone'],
            "dob" => $post_vars['dob'],
            "gender" => $post_vars['gender'],
            "address" => $post_vars['address'],
            "role" => $post_vars['role'],
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

    /**
     * logs user out
     */
    public function logout()
    {
        $this->repository->logout();
        return $this->sendSuccess([], "User Logged Out Succesfully");
    }
}
