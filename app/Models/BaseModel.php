<?php

namespace App\Models;

use App\Core\Database;
use PDO;

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
     * @var String query string to execute
     */
    protected $query;

     /**
     * @var int id primary key
     */
    protected $id;

    public function __construct()
    {
        if(!$this->db)
            $this->db = Database::getConnection();
        if(!self::$id)
            self::$id = 1; 
        self::$id = (int) self::$id;
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
     * Insert multiple data at once
     */
    public function createMultiple($columns, $values)
    {
        $columns = implode(",",$columns);
        $rows = [];
        foreach($values as $key => $row)
        {
            $bindings = [];
            for($i = 0; $i<count($row); $i++)
            {
                $bindings[$i] = "?";
            }
            $qs[$key] = "(" . implode(",", $bindings) . ")";
            $rows = array_merge($rows, $row);
        }

        $query = "INSERT INTO " . $this->table . "(" . $columns . ") VALUES " . implode(",", $qs);

        $stmt = $this->db->prepare($query);

        $stmt->execute($rows);

    }

    /**
     * Update item in database
     */
    public function update($id, $columns, $values)
    {
        $qs = "";
        for($i = 0; $i < count($columns); $i++)
        {
            if($i != (count($columns) -1))
            {
                $qs .= $columns[$i] . " = ?, ";
            } else {
                $qs .= $columns[$i] . " = ? ";
            }
        }
        $query = "UPDATE " . $this->table . " SET " . $qs . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        array_push($values, $id);
        $stmt->execute($values);
        return true;
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
    
    /**
     * fetch data in paginated format
     * @param int current page
     * @param int limit per page
     */
    public function paginate($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $totalQuery = "SELECT COUNT(*) AS total FROM " . $this->table;
        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->execute();
        $totalRecords = $totalStmt->fetch()['total'];
        $totalPages = ceil($totalRecords / $limit);

        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        $records = $stmt->fetchAll();
        $response = [
            'data' => $records,
            'total' => $totalRecords,
            'totalPages' => $totalPages,
            'from' => $offset + 1,
            'to' => $offset + count($records)
        ];
        return $response;
    }

    /**
     * delete data 
     */
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return true;
    }

    /**
     * return count of total data
     */
    public function countAll()
    {
        $query = "SELECT COUNT(*) AS count FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['count'];
    }

    /**
     * return value by id from database
     */
    public function find($id = null)
    {
        if($id ?? false)
        {
            $this->id = $id;
            return Database::find();
        }
    }
}