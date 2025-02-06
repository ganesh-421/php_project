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
     * find data by specified column
     */
    public function findBy($data)
    {
        $col = array_keys($data)[0];
        $val = $data[$col];
        return $this->model->findBy($col, $val);
    }
   
}