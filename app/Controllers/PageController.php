<?php

namespace App\Controllers;

use App\Models\Artist;
use App\Models\Music;
use App\Models\User;

class PageController
{
    public function landing()
    {
        if($_SESSION['user_id'])
        {
            header("Location: /dashboard");
        } else {
            $_SESSION['error'] = "Session Expired";
            header("Location: /login");
        }
    }

    public function dashboard()
    {
        if(!$_SESSION['user_id'])
        {
            header("Location: /login");
        }
        $artist_count = (new Artist())->countAll();
        $music_count = (new Music())->countAll();
        $user_count = (new User())->countAll();
        $recent_songs = (new Music())->paginate(1, 10)['data'];
        require_once __DIR__ . '/../Views/auth/dashboard.php';
    }
}
