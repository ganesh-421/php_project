<?php

namespace App\Models;

use App\Core\Request;

class Session extends BaseModel
{
    /**
     * initializes class 
     */
    public function __construct()
    {
        parent::__construct();
        if(session_status() === PHP_SESSION_DISABLED)
            session_start();
        $this->table = "session";
    }

    /**
     * get currently active session detail
     */
    public function current()
    {
        if(!Request::expectJson())
        {
            $token = $_SESSION['token'];
            $result = $this->findBy('token', $token);
            return $result[0];
        } else {
            $token = Request::getAuthSession();
            $result = $this->findBy('token', $token);
            return $result[0];
        }
    }

    /**
     * get currently authenticated user
     */
    public function auth()
    {
        if(!Request::expectJson())
        {
            if(isset($_SESSION['token']))
            {
                $token = $_SESSION['token'];
                return $this->user($token);
            }
            return false;
        } else {
            $token = Request::getAuthSession();
            return $this->user($token);
        }
    }

    /**
     * get user associated with this session token
     * @param string
     */
    public function user($token)
    {
        $query = "SELECT `user`.* FROM `user` INNER JOIN `session` ON `user`.`id` = `session`.`user_id` WHERE `session`.`token`=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    /**
     * get role of currently authenticated user
     */
    public function role()
    {
        return $this->auth()['role'];
    }

    /**
     * get fullname of currently authenticated user
     */
    public function name()
    {
        $user = $this->auth();
        return $user['first_name'] . " " . $user['last_name'];
    }
}