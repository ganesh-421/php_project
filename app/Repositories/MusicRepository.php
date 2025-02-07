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

    /**
     * paginated records
     * @param int|null $page
     * @param int|null $per_page 
     */
    public function paginated(?int $page, ?int $per_page)
    {
        return $this->model->paginate($page, $per_page);
    }
}