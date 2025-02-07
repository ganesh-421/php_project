<?php

namespace App\Controllers;

use App\Repositories\ArtistRepository;

class ArtistController
{
    private $repository;
    public function __construct()
    {
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
            exit;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND);
            $this->repository->add($_POST);
            header("Location: /artists");
            exit;
        } else {
            require_once __DIR__ . '/../Views/auth/artist/create.php';
        }
    }

    public function edit()
    {
        $id = $_REQUEST['artist_id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_POST['artist_id']);
            $this->repository->update($id, $_POST);
            header("Location: /artists");
            exit;
        } else {
            $artist = $this->repository->findBy(['id' => $id])[0];
            require_once __DIR__ . '/../Views/auth/artist/edit.php';
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND);
            $this->repository->delete($_POST['artist_id']);
            $_SESSION['success'] = "Artist deleted succesfully";
            header("Location: /artists");
            exit;
        }
    }
}