<?php

namespace App\Models;

class Session extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->table = "session";
    }

    public function current()
    {
        $token = $_SESSION['token'];
        $query = "SELECT * FROM `session` WHERE `session`.`token`=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function auth()
    {
        $token = $_SESSION['token'];
        $query = "SELECT * FROM `user` INNER JOIN `session` ON `user`.`id` = `session`.`user_id` WHERE `session`.`token`=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function role()
    {
        return $this->auth()['role'];
    }

    public function name()
    {
        $user = $this->auth();
        return $user['first_name'] . " " . $user['last_name'];
    }
}