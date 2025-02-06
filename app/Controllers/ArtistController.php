<?php

namespace App\Controllers;

use App\Repositories\ArtistRepository;

use function PHPSTORM_META\type;

class ArtistController
{
    private $repository;
    public function __construct()
    {
        $this->repository = new ArtistRepository();
    }
    public function index()
    {
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
            exit;
        }
        $artists = $this->repository->getAll();
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
}