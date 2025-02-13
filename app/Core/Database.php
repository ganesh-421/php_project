<?php

namespace App\Core;

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
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=localhost;dbname=cms_project;charset=utf8mb4";
                // $dsn = "mysql:host=db;dbname=cms_project;charset=utf8mb4";
                self::$instance = new PDO($dsn, 'ganesh', 'gnsgnss', [
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