<?php

namespace App\Controllers;

use App\Core\Validator;
use App\Models\Artist;
use App\Models\Session;
use App\Repositories\ArtistRepository;

class ArtistController
{
    private $repository;
    public function __construct()
    {
        if(!(((new Session())->role() != 'artist_manager') || ((new Session())->role() != 'super_admin')))
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }
        $this->repository = new ArtistRepository();
    }
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $artists = $this->repository->paginated($page, 5);
        require_once __DIR__ . '/../Views/auth/artist/index.php';
    }

    public function create()
    {
        if(((new Session())->role() != 'artist_manager'))
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rules = [
                "first_name" => 'required|min:3|max:255',
                "last_name" => 'required|min:3|max:255',
                "email" => 'required|email|unique:user,email',
                "password" => 'required|min:8|max:15',
                "phone" => 'required|min:10|max:10|unique:user,phone',
                "dob" => 'required|before:today',
                "gender" => 'required|in:m,f,o',
                "address" => 'required|min:3|max:255',
                "role" => 'required|in:super_admin,admin,artist',
                'first_release_year' => 'required|min:4|numeric|before:today',
                'no_of_albums' => 'required|numeric',
            ];
            $data = [
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "password" => $_POST['password'],
                "phone" => $_POST['phone'],
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                "role" => 'artist',
                'first_release_year' => $_POST['first_release_year'],
                'no_of_albums' => $_POST['no_of_albums'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $validator = new Validator($data, $rules, (new Artist()));
            if(!$validator->validate()) {
                $errors = $validator->errors();
                $_SESSION['errors'] = $errors;
                header("Location: /create/artist");
                exit;
            }
            $result = $this->repository->add($data);
            if($result) 
            {
                $_SESSION['success'] = "Artist Added Succesfully";
                header("Location: /artists");
                exit;
            } else {
                // $_SESSION['error'] = "Artist Couldn't be Added";
                header("Location: /create/artist");
                exit;
            }
        } else {
            require_once __DIR__ . '/../Views/auth/artist/create.php';
        }
    }

    public function edit()
    {
        $id = $_REQUEST['artist_id'];
        $artist = (new Artist())->find($id);
        if(empty($artist))
        {
            $_SESSION['error'] = "Artist Not Found";
            header("Location: /artists");
            exit;
        }
        if(((new Session())->role() != 'artist_manager'))
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rules = [
                "name" => 'min:3|max:255',
                "dob" => 'before:today',
                "gender" => 'in:m,f,o',
                "address" => 'min:3|max:255',
                'first_release_year' => 'min:4|numeric',
                'no_of_albums_released' => 'numeric',
            ];
    
            $data = [
                "name" => $_POST['name'] ,
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                'first_release_year' => $_POST['first_release_year'],
                'no_of_albums_released' => $_POST['no_of_albums_released'],
                "updated_at" => date('Y-m-d H:i:s'),
            ];
    
            $validator = new Validator($data, $rules, (new Artist()));
                
            if(!$validator->validate()) {
                $errors = $validator->errors();
                $_SESSION['errors'] = $errors;
                header("Location: /update/artist?artist_id=".$id);
                exit;
            }
            $result = $this->repository->update($id, $data);
            if($result) 
            {
                $_SESSION['success'] = "Artist Updated Succesfully";
                header("Location: /artists");
                exit;
            } else {
                $_SESSION['error'] = "Artist Couldn't be Updated";
                header("Location: /update/artist?artist_id=".$id);
                exit;
            }
        } else {
            $artist = $this->repository->findBy(['id' => $id])[0];
            require_once __DIR__ . '/../Views/auth/artist/edit.php';
        }
    }

    public function delete()
    {
        $id = $_REQUEST['artist_id'];
        $artist = (new Artist())->find($id);
        if(empty($artist))
        {
            $_SESSION['error'] = "Artist Not Found";
            header("Location: /artists");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->delete($id);
            if($result) 
            {
                $_SESSION['success'] = "Artist deleted succesfully";
                header("Location: /artists");
                exit;
            } else {
                $_SESSION['error'] = "Artist Couldn't be deleted";
                header("Location: /artists");
                exit;
            }
        }
    }

    public function exportCsv()
    {
        $filename = "artists.csv";
        $this->repository->export($filename);
        $file = "exports/" . $filename;

        
        if (!file_exists($file)) {
            $_SESSION['error'] = "Failed to export records.";
            return;
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        
        readfile($file);
        $_SESSION['success'] = "All Records Exported";
        exit();
    }

    public function importCsv()
    {
        if (isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (strtolower($extension) !== 'csv') {
                $_SESSION['error'] = "Only csv are valid.";
                header("Location: /artists");
                exit;
            }
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Error while file upload.";
                header("Location: /artists");
                exit;
            }
            
            $result = $this->repository->import($file);
            if(!$result)
            {
                $_SESSION['error'] = "Import Failed";
                header("Location: /artists");
                exit;
            }
            $_SESSION['success'] = "Succesfully Imported";
            header("Location: /artists");
            exit;
        } else {
            $_SESSION['success'] = "No file uploaded.";
            header("Location: /artists");
            exit;
        }
    }
}