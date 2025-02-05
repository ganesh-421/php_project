<?php

namespace App\Controllers;

use App\Models\TestModel;

class PageController
{
    public function landing()
    {
        $test = new TestModel();
        require __DIR__ . '/../Views/front/landing.php';
    }

    public function login()
    {
        require_once __DIR__ . '/../Views/front/login.php';
    }

    public function register()
    {
        require_once __DIR__ . '/../Views/front/register.php';
    }
}
