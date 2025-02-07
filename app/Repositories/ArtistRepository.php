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
     * registers new user in database
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

    /**
     * paginated records
     * @param int|null $page
     * @param int|null $per_page 
     */
    public function paginated(?int $page, ?int $per_page)
    {
        return $this->model->paginate($page, $per_page);
    }

    /**
     * exports data into csv
     */
    public function export($filename = "artists.csv")
    {
        $stream = fopen('exports/' . $filename, "w");
        fputcsv($stream, $this->model->fields);
        $data = $this->getAll();
        foreach($data as $row)
        {
            fputcsv($stream, $row);
        }
        return fclose($stream);
    }
}