<?php

namespace App\Repositories;

use App\Models\Artist;
use Exception;

class ArtistRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Artist();
    }

    /**
     * registers nee user in database
     * @param array 
     * @return bool
     */
    public function add($data)
    {
        try {
            $data = [
                "name" => $data['name'],
                "dob" => $data['dob'],
                "gender" => $data['gender'],
                "address" => $data['address'],
                "first_release_year" => $data['first_release_year'],
                "no_of_albums_released" => $data['no_of_albums_released'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $this->create($data);
            $_SESSION['success'] = "Artist Created Succesfully";
            return true;
        } catch(Exception $e)
        {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * get all artists
     */
    public function getAll()
    {
        return $this->model->all();
    }
}