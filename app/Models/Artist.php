<?php

namespace App\Models;

class Artist extends BaseModel
{
    public $fields = ["id","user_id", "name", "dob", "gender", "address", "first_release_year", "no_of_albums_released", "created_at", "updated_at"];
    public function __construct()
    {
        parent::__construct();
        $this->table = "artist";
    }
}
