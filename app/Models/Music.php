<?php

namespace App\Models;

class Music extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "music";
    }
}
