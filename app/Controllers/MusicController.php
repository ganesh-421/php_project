<?php

namespace App\Controllers;

use App\Models\Artist;
use App\Models\Music;
use App\Models\Session;
use App\Repositories\MusicRepository;

class MusicController
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
            $musics = $this->repository->findBy(['artist_id' => $_GET['artist_id']]);
            require_once __DIR__ . '/../Views/auth/music/index.php';
            exit;
        } else {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $musics = $this->repository->paginated($page, 5);
            require_once __DIR__ . '/../Views/auth/music/index.php';
            exit;
        }
    }

    public function create()
    {
        $authUser = (((new Session())->auth()));
        $artist = (new Artist())->find($_REQUEST['artist_id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if( $authUser['role'] != 'artist' || $authUser['id'] != $artist['user_id'])
            {
                $_SESSION['error'] = "Unauthorized.";
                header("Location: /");
            }
            $data = [
                "artist_id" => $_REQUEST['artist_id'],
                "title" => $_POST['title'],
                "album_name" => $_POST['album_name'],
                "genre" => $_POST['genre'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->repository->add($data);
            if($result) 
            {
                $_SESSION['success'] = "Music Added Succesfully";
                header("Location: /musics");
                exit;
            } else {
                $_SESSION['error'] = "Music Couldn't be Added";
                header("Location: /create/music");
                exit;
            }
        } else {
            if( $authUser['role'] != 'artist')
            {
                $_SESSION['error'] = "Unauthorized.";
                header("Location: /");
            }
            $artist = (new Artist())->findBy('user_id', $authUser['id'])[0];
            $genres = ['rnb', 'country', 'classic', 'rock', 'jazz'];
            require_once __DIR__ . '/../Views/auth/music/create.php';
        }
    }

    public function edit()
    {
        $id = $_REQUEST['music_id'];
        $authUser = (new Session())->auth();
        $music = (new Music())->find($id);
        $artist = (new Artist())->find($music['artist_id']);

        if($authUser['role'] != 'artist' || $authUser['id'] != $artist['user_id'])
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }                     
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "artist_id" => $_REQUEST['artist_id'],
                "title" => $_POST['title'],
                "album_name" => $_POST['album_name'],
                "genre" => $_POST['genre'],
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->repository->update($id, $data);
            if($result) 
            {
                $_SESSION['success'] = "Music Updated Succesfully";
                header("Location: /musics");
                exit;
            } else {
                $_SESSION['error'] = "Music Couldn't be Updated";
                header("Location: /update/music?music_id=".$id);
                exit;
            }
        } else {
            if((new Session())->role() != 'artist')
            {
                $_SESSION['error'] = "Unauthorized.";
                header("Location: /");
            }
            $music = $this->repository->findBy(['id' => $id])[0];
            $artists = (new Artist())->all();
            $genres = ['rnb', 'country', 'classic', 'rock', 'jazz'];
            require_once __DIR__ . '/../Views/auth/music/edit.php';
        }
    }

    public function delete()
    {
        if((new Session())->role() != 'artist')
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->delete($_POST['music_id']);
            if($result) {

                $_SESSION['success'] = "Music deleted succesfully";
                header("Location: /musics");
                exit;
            } else {
                $_SESSION['error'] = "Music couldn't be deleted";
                header("Location: /musics");
                exit;
            }
        }
    }
}