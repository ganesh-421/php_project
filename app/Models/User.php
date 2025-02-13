<?php

namespace App\Models;

class User extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "user";
    }
}
