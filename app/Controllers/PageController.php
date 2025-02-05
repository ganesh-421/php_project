<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\User;

class PageController
{
    public function landing()
    {
        $test = new TestModel();
        require_once __DIR__ . '/../Views/front/landing.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $result = $user->login($_POST['email'], $_POST['password']);
            if($result)
            {
                header("Location: /dashboard");
            } else {
                $_SESSION['error'] = "Invalid Credentials";
                header("Location: /login");
            }
        } else {
            if($_SESSION['user_id'])
            {
                header("Location: /dashboard");
            }
            require_once __DIR__ . '/../Views/front/login.php';
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $user = new User();
            $result = $user->register($_POST);
            if(!$result)
            {
                header("Location: /register");
            } else {
                header("Location: /login");
            }
        } else {
            if($_SESSION['user_id'])
            {
                header("Location: /dashboard");
            }
            require_once __DIR__ . '/../Views/front/register.php';
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
