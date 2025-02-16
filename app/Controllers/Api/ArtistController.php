<?php

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\Artist;
use App\Models\Session;
use App\Repositories\ArtistRepository;
use App\Transformers\ArtistTransformer;

class ArtistController extends BaseApiController
{
    private $repository;
    public function __construct()
    {
        if(!(((new Session())->role() != 'artist_manager') || ((new Session())->role() != 'super_admin')))
        {
            return $this->sendError("Unauthorized", 403);
        }
        $this->repository = new ArtistRepository();
    }
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $artists = ArtistTransformer::transformPaginated($this->repository->paginated($page, 5));
        return $this->sendSuccess($artists, "List Of Artist");
    }

    public function create()
    {
        if(((new Session())->role() != 'artist_manager'))
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }
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
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->add($data);
        if($result) 
        {
            return $this->sendSuccess([], "Artist Added Succesfully");
        } else {
            return $this->sendError("Artist Couldn't Be Added");
        }
    }

    public function edit()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['artist_id'];
        $artist = (new Artist())->find($id);

        if(empty($artist))
        {
            return $this->sendError("Artist Not Found", 404);
        }
        if(((new Session())->role() != 'artist_manager'))
        {
            return $this->sendError("Unauthorized", 403);
        }

        $rules = [
            "name" => 'min:3|max:255',
            "dob" => 'before:today',
            "gender" => 'in:m,f,o',
            "address" => 'min:3|max:255',
            'first_release_year' => 'min:4|numeric|before:today',
            'no_of_albums' => 'numeric',
        ];
        $data = [
            "name" => $post_vars['name'] ,
            "dob" => $post_vars['dob'],
            "gender" => $post_vars['gender'],
            "address" => $post_vars['address'],
            'first_release_year' => $post_vars['first_release_year'],
            'no_of_albums' => $post_vars['no_of_albums'],
            "updated_at" => date('Y-m-d H:i:s'),
        ];

        $validator = new Validator($data, $rules, (new Artist()));
        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }
        
        $result = $this->repository->update($id, $data);
        if($result) 
        {
            return $this->sendSuccess([], "Artist Updated Succesfully");
        } else {
            return $this->sendError("Artist Couldn't be Updated");
        }
    }

    public function delete()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['artist_id'];
        $artist = (new Artist())->find($id);
        if(empty($artist))
        {
            return $this->sendError("Artist Not Found", 404);
        }
        $result = $this->repository->delete($_POST['artist_id']);
        if($result) 
        {
            return $this->sendSuccess([], "Artist Deleted Succesfully");
        } else {
            return $this->sendError("Artist Couldn't be Deleted");
        }
    }

    public function exportCsv()
    {
        $filename = "artists.csv";
        $this->repository->export($filename);
        $file = "exports/" . $filename;

        
        if (!file_exists($file)) {
            return $this->sendError("Artist Couldn't be Exported");
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        
        readfile($file);
        $this->sendSuccess([], "Artist Exported");
    }

    public function importCsv()
    {
        if (isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (strtolower($extension) !== 'csv') {
                return $this->sendError("Only CSV file are valid");
            }
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return $this->sendError("Error While Uploading");
            }
            
            $result = $this->repository->import($file);
            if(!$result)
            {
                return $this->sendError("Artist Couldn't be Imported");
            }
            return $this->sendSuccess([], "Artist Imported Successfully");
        } else {
            return $this->sendError("File not uploaded");
        }
    }
}