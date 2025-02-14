<?php

namespace App\Repositories;

use App\Models\Artist;
use Exception;

class ArtistRepository extends BaseRepository
{
    private $auth;
    public function __construct()
    {
        $this->model = new Artist();
        $this->auth = new AuthRepository();
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
                "name" => $data['first_name'] . " " . $data['last_name'],
                "dob" => $data['dob'],
                "gender" => $data['gender'],
                "address" => $data['address'],
                "first_release_year" => $data['first_release_year'],
                "no_of_albums_released" => $data['no_of_albums_released'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            
            $userData = [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "email" => $data['email'],
                "password" => $data['password'],
                "phone" => $data['phone'],
                "dob" => $data['dob'],
                "gender" => $data['gender'],
                "role" => 'artist',
                "address" => $data['address'],
                "first_release_year" => $data['first_release_year'],
                "no_of_albums_released" => $data['no_of_albums_released'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $this->auth->createRegistration($userData);
            $data['user_id'] = $this->auth->findByEmail($data['email'])['id'];
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

    /**
     * store data from csv file into table
     */
    public function import($file)
    {
        $stream = fopen($file['tmp_name'], 'r');
        fgetcsv($stream);
        while(($row = fgetcsv($stream)) !== FALSE)
        {
            if(count($this->model->fields) !== count($row))
            {
                $_SESSION['error'] = "Invalid CSV file";
                return false;
            } else {
                $data[] = $row;
            }
        }
        $this->model->createMultiple($this->model->fields, $data);
        return;
    }
}