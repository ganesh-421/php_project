<?php

namespace App\Core;

use App\Config\Config;
use PDO;
use PDOException;

class Database 
{
    /**
     * @var PDO instance $instance (connection to database).
    */    
    private static $instance = null;

    public static function getConnection()
    {
        $user = Config::database('user');
        $password = Config::database('password');
        $name = Config::database('name');
        $host = Config::database('host');
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=". $host .";dbname=cms_project;charset=utf8mb4";
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}