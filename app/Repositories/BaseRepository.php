<?php

namespace App\Repositories;

use App\Core\Database;
use Exception;

class BaseRepository
{
    /**
     * @var Model model instance [database connection instance]
     */
    public $model;

    public function create(array $data)
    {
        try {

            $cols = array_keys($data);
            $vals = array_values($data);
           return $this->model->create($cols, $vals);
        } catch(Exception $e)
        {
            // $_SESSION['error'] = "Something Went Wrong";
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * updates the items in database
     */
    public function update($id, array $data)
    {
        try {
            $cols = array_keys($data);
            $vals = array_values($data);
            $this->model->update($id, $cols, $vals);
            return true;
        } catch(Exception $e)
        {
            $_SESSION['error'] = "Something Went Wrong";
            return false;
        }
    }

    /**
     * find data by specified column
     */
    public function findBy($data)
    {
        try {

            $col = array_keys($data)[0];
            $val = $data[$col];
            return $this->model->findBy($col, $val);
        } catch(Exception $e)
        {
            $_SESSION['error'] = "Something Went Wrong";
            return false;
        }
    }

    /**
     * delete item from database
     */
    public function delete($id)
    {
        try {

            return $this->model->delete($id);
        } catch(Exception $e)
        {
            $_SESSION['error'] = "Something Went Wrong";
            return false;
        }
    }

    /**
     * find by id 
     */
    public function find($id)
    {
        try {
            return $this->model->delete($id);
        } catch(Exception $e)
        {
            $_SESSION['error'] = "Something Went Wrong";
            return false;
        }
    }
}