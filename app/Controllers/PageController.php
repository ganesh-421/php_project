<?php

namespace App\Controllers;

use App\Models\Artist;
use App\Models\Music;
use App\Models\Session;
use App\Models\User;

class PageController
{
    /**
     * returns landing page
     */
    public function landing()
    {
        if(!(new Session)->auth())
        {
            header("Location: /login");
            exit;
        } else {
            header("Location: /dashboard");
            exit;
        }
    }

    /**
     * returns dashboard page
     */
    public function dashboard()
    {
        $artist_count = (new Artist())->countAll();
        $music_count = (new Music())->countAll();
        $user_count = (new User())->countAll();
        $recent_songs = (new Music())->paginate(1, 10)['data'];
        require_once __DIR__ . '/../Views/auth/dashboard.php';
        exit;
    }
}
