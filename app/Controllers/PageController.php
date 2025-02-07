<?php

namespace App\Controllers;

class PageController
{
    public function landing()
    {
        if($_SESSION['user_id'])
        {
            header("Location: /dashboard");
        } else {
            header("Location: /login");
        }
    }

    public function dashboard()
    {
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
        }
        require_once __DIR__ . '/../Views/auth/dashboard.php';
    }

    public function artist()
    {
        $item = "Helloooooooooooooo";
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
        }
        require_once __DIR__ . '/../Views/auth/artist.php';
    }
}
