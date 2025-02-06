<?php

namespace App\Models;

class Artist extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "artist";
    }
}
