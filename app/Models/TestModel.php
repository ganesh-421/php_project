<?php

namespace App\Models;

use App\Core\Database;

class TestModel
{
    /**
     * @var PDO instance $db (connection to database).
     */
    private $db;

    public function __construct()
    {
        try {

            $this->db = Database::getConnection();
            $stmt = $this->db->prepare("CREATE TABLE users(id int not null, name varchar(255))");
            $stmt->execute();
        } catch(\Exception $e)
        {
            die($e->getMessage() . " From Model");
        }
    }
}