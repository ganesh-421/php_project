<?php

namespace App\Repositories;

use App\Models\Music;
use Exception;

class MusicRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Music();
    }

    /**
     * registers new user in database
     * @param array 
     * @return bool
     */
    public function add($data)
    {
        try {
            $data = [
                "artist_id" => $data['artist_id'],
                "title" => $data['title'],
                "album_name" => $data['album_name'],
                "genre" => $data['genre'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $this->create($data);
            $_SESSION['success'] = "Music Created Succesfully";
            return true;
        } catch(Exception $e)
        {
            $_SESSION['error'] = $e->getMessage();
            return false; 
        }
    }

    /**
     * get all musics
     */
    public function getAll()
    {
        return $this->model->all();
    }
}