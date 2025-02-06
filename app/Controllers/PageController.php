<?php

namespace App\Controllers;

use App\Models\User;

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
        require_once __DIR__ . '/../Views/front/dashboard.php';
    }
}
