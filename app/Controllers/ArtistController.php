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
        $artists = $this->repository->getAll();
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
        }
        require_once __DIR__ . '/../Views/auth/artist/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->add($_POST);
            header("Location: /artists");
        } else {
            require_once __DIR__ . '/../Views/auth/artist/create.php';
        }
    }
}