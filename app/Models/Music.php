<?php

namespace App\Models;

class Music extends BaseModel
{
    public $fields = ["id", "artist_id", "title", "album_name", "genre", "created_at", "updated_at"];
    public function __construct()
    {
        parent::__construct();
        $this->table = "music";
    }
}
