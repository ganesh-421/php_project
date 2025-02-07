<?php

namespace App\Controllers;

use App\Models\Artist;
use App\Repositories\MusicRepository;

class MusicController
{
    private $repository;
    public function __construct()
    {
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
            exit;
        }
        $this->repository = new MusicRepository();
    }
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $musics = $this->repository->paginated($page, 5);
        require_once __DIR__ . '/../Views/auth/music/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->add($_POST);
            header("Location: /musics");
            exit;
        } else {
            $artists = (new Artist())->all();
            $genres = ['rnb', 'country', 'classic', 'rock', 'jazz'];
            require_once __DIR__ . '/../Views/auth/music/create.php';
        }
    }

    public function edit()
    {
        $id = $_REQUEST['music_id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_POST['music_id']);
            $this->repository->update($id, $_POST);
            header("Location: /musics");
            exit;
        } else {
            $music = $this->repository->findBy(['id' => $id])[0];
            $artists = (new Artist())->all();
            $genres = ['rnb', 'country', 'classic', 'rock', 'jazz'];
            require_once __DIR__ . '/../Views/auth/music/edit.php';
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND);
            $this->repository->delete($_POST['music_id']);
            $_SESSION['success'] = "Music deleted succesfully";
            header("Location: /musics");
            exit;
        }
    }
}