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
}