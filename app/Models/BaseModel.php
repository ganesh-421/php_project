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

    /**
     * @var String [query string]
     */
    public $stmt;

    /** */

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * sets sql statement
     * @param String 
     */
    public function setStatement($stmt)
    {
        $this->stmt = $stmt;
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
        return $stmt->fetch();       
     }
}