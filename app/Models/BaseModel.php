<?php

namespace App\Models;

use App\Core\Database;

class BaseModel
{
    /**
     * @var PDO instance [database connection instance]
     */
    protected $db;

    /**
     * @var String [table name]
     */
    protected $table;

    public function __construct()
    {
        if(!$this->db)
            $this->db = Database::getConnection();
    }

    /**
     * creates item in table
     */
    public function create($columns, $values)
    {
        $columns = implode(",",$columns);
        $bindings = [];
        for($i=0; $i<count($values); $i++)
        {
            $bindings[$i] = "?";
        }
        $qs = implode(",", $bindings);
        $query = "INSERT INTO " . $this->table . "(" . $columns . ") VALUES(" . $qs . ")";

        $stmt = $this->db->prepare($query);

        $stmt->execute($values);
    }

    /**
     * find items by specified column
     */
     public function findBy($column, $value)
     {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $column . " = ?";
        $stmt =  $this->db->prepare($query);

        $stmt->execute([$value]);
        return $stmt->fetchAll();       
     }

     /**
      * get all items from database
      */
      public function all()
      {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
      }
}