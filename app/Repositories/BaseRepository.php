<?php

namespace App\Repositories;

use App\Core\Database;

class BaseRepository
{
    /**
     * @var Model model instance [database connection instance]
     */
    protected $model;

    public function create(array $data)
    {
        $cols = array_keys($data);
        $vals = array_values($data);
        $this->model->create($cols, $vals);
    }

    /**
     * updates the items in database
     */
    public function update($id, array $data)
    {
        $cols = array_keys($data);
        $vals = array_values($data);
        $this->model->update($id, $cols, $vals);
    }

    /**
     * find data by specified column
     */
    public function findBy($data)
    {
        $col = array_keys($data)[0];
        $val = $data[$col];
        return $this->model->findBy($col, $val);
    }

    /**
     * delete item from database
     */
    public function delete($id)
    {
        return $this->model->delete($id);
    }
   
}