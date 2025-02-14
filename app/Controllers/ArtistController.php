<?php

namespace App\Controllers;

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
            $result = $this->repository->add($_POST);
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
        if(((new Session())->role() != 'artist_manager'))
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }
        $id = $_REQUEST['artist_id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_POST['artist_id']);
            $result = $this->repository->update($id, $_POST);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND);
            $result = $this->repository->delete($_POST['artist_id']);
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
                unset($_SESSION['success']);
                header("Location: /artists");
                exit;
            }
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Error while file upload.";
                unset($_SESSION['success']);
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