<?php

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Session;
use App\Repositories\MusicRepository;
use App\Transformers\MusicTransformer;

class MusicController extends BaseApiController
{
    private $repository;
    public function __construct()
    {
        $this->repository = new MusicRepository();
    }
    public function index()
    {
        if(isset($_GET['artist_id']))
        {
            $musics = MusicTransformer::transformCollection($this->repository->findBy(['artist_id' => $_GET['artist_id']]));
            return $this->sendSuccess($musics, "List Of Music For Artist");
        } else {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $musics = MusicTransformer::transformPaginated($this->repository->paginated($page, 5));
            return $this->sendSuccess($musics, "List Of Music");
        }
    }

    public function create()
    {
        $authUser = (((new Session())->auth()));
        $artist = (new Artist())->find($_REQUEST['artist_id']);
        if( $authUser['role'] != 'artist' || $authUser['id'] != $artist['user_id'])
        {
            return $this->sendError("Unauthorized", 403);
        }
        $rules = [
            'artist_id' => 'required|exists:artist,id',
            'title' => 'required|max:255|min:3',
            'album_name' => 'required|max:255|min:3',
            'genre' => 'required|in:rnb,country,classic,rock,jazz'
        ];

        $data = [
            "artist_id" => $_REQUEST['artist_id'],
            "title" => $_POST['title'],
            "album_name" => $_POST['album_name'],
            "genre" => $_POST['genre'],
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ];

        $validator = new Validator($data, $rules, (new Music()));

        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->add($data);
        if($result) 
        {
            return $this->sendSuccess([], "Music Added Succesfully");
        } else {
            return $this->sendError("Music Couldn't Be Added");
        }
    }

    public function edit()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['music_id'];
        $music = (new Music())->find($id);
        if(empty($music))
        {
            return $this->sendError("Music Not Found", 404);
        }
        $authUser = (new Session())->auth();
        $artist = (new Artist())->find($music['artist_id']);

        if($authUser['role'] != 'artist' || $authUser['id'] != $artist['user_id'])
        {
            return $this->sendError("Unauthorized", 403);
        }                     
        $rules = [
            'artist_id' => 'exists:artist,id',
            'title' => 'min:3|max:255',
            'album_name' => 'min:3|max:255',
            'genre' => 'in:rnb,country,classic,rock,jazz'
        ];

        $data = [
            "artist_id" => $_REQUEST['artist_id'] ?? $music['artist_id'],
            "title" => $post_vars['title'] ?? $music['title'],
            "album_name" => $post_vars['album_name'] ?? $music['album_name'],
            "genre" => $post_vars['genre'] ?? $music['genre'],
            "updated_at" => date('Y-m-d H:i:s'),
        ];

        $validator = new Validator($data, $rules, (new Music()));
        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->update($id, $data);

        if($result) 
        {
           return $this->sendSuccess([], "Music Updated Succesfully");
        } else {
            return $this->sendError("Music Couldn't Be Updated");
        }
    }

    public function delete()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['music_id'];
        $music = (new Music())->find($id);
        if(empty($music))
        {
            return $this->sendError("Music Not Found", 404);
        }
        $authUser = (new Session())->auth();
        $artist = (new Artist())->find($music['artist_id']);
        if($authUser['role'] != 'artist' || $authUser['id'] != $artist['user_id'])
        {
            return $this->sendError("Unauthorized", 403);
        } 
        $result = $this->repository->delete($id);
        if($result) {
            return $this->sendSuccess([], "Music Deleted Succesfully");
        } else {
            return $this->sendError("Music Couldn't Be Deleted");
        }
    }
}