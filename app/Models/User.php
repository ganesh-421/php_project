<?php

namespace App\Models;

use App\Core\Database;
use Exception;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * registers nee user in database
     * @param array 
     * @return bool
     */
    public function register($data)
    {
        try {

            $user = $this->findByEmail($data['email']);
            if($user)
            {
                $_SESSION['error'] = "Email already exists";
                return false;
            }
            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $phone = $data['phone'];
            $dob = $data['dob']; 
            $gender = $data['gender'];
            $address = $data['address'];
            $role = $data['role'];
            $created_at = $updated_at = date('Y-m-d H:i:s');
            
            $stmt = $this->db->prepare("
                INSERT INTO user 
                (first_name, last_name, email, password, phone, dob, gender, address, role, created_at, updated_at) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $first_name, $last_name, $email, $password, 
                $phone, $dob, $gender, $address, $role, $created_at, $updated_at
            ]);
            $_SESSION['success'] = "Succesfully registered";
            return true;
        } catch(Exception $e)
        {
            $_SESSION['error'] = $e->getMessage();
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
        try {

            $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);  
            return $stmt->fetch();
        } catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
