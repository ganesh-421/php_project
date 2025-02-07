<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

class AuthRepository extends BaseRepository
{    
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * registers nee user in database
     * @param array 
     * @return bool
     */
    public function register($data)
    {
        try {
            $user = $this->findBy(['email' => $data['email']]);
            if($user)
            {
                $_SESSION['error'] = "Email already exists";
                return false;
            }
            $this->create($data);
            return true;
        } catch(Exception $e)
        {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Edit the user detail
     */
    public function edit($id, $data)
    {
        try {
            $user = $this->findBy(['email' => $data['email']])[0];
            if($user && ($user['id'] != $id))
            {
                $_SESSION['error'] = "Email already exists";
                return false;
            }
            $result = $this->update($id, $data);
            return $result;
        } catch(Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

     /**
     * logs user into the system
     * @param string 
     * @param string 
     * @return bool
     */
    public function login($email, $password)
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    /**
     * finds user by email
     * @param string
     * @return array 
     */
    public function findByEmail($email)
    {
        return $this->findBy([
            'email' => $email
        ])[0];
    }

    /**
     * fetch all user from database
     */
    public function getAll()
    {
        return $this->model->all();
    }

     /**
     * paginated records
     * @param int|null $page
     * @param int|null $per_page 
     */
    public function paginated(?int $page, ?int $per_page)
    {
        return $this->model->paginate($page, $per_page);
    }
}