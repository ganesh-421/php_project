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

    /**
     * @var string query string to execute
     */
    protected $query = null;

    /**
     * @var int id primary key
     */
    protected $id = null;

    /**
     * @var string table name 
     */
    protected $table = null;

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

    /**
     * executes query in database
     */
    public function execute($query = null)
    {
        if($query ?? false)
        {
            $stmt = self::$instance->prepare($this->query);
            $stmt->execute();
            return $stmt;
        }
    } 

    /**
     * return current instance
     */
    public static function find()
    {
        if(self::$id ?? false)
        {
            try {
                static::$query = "SELECT * FROM " . static::$table . " WHERE id=?";
                return self::execute([self::$id])->fetch();
            } catch (PDOException $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
    }

    /**
     * return count of the instance
     */
    public static function count()
    {
        try {
            static::$query = "SELECT COUNT(*) as count FROM " . static::$table . " WHERE id=?";
            return self::execute([self::$id]);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }
}