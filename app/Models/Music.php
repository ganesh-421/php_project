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

    public function user($id)
    {
        $query = "SELECT `user`.`*`, `music`.`id` FROM `music` 
                INNER JOIN `artist`
                ON `music`.`artist_id` = `artist`.`id` 
                INNER JOIN `user`
                ON `artist`.`user_id` =  `user`.`id`
                WHERE `music`.`id`=?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        return $user;
    }
}
